drop table Reviews;
-- cascade delete from games

drop table Friends;
-- cascade delete from members

drop table Purchases;
-- cascade delete from customers and games

drop table AddRemoveFromWishlist;
-- cascade delete from games and wishlists

drop table AddRemoveFromCart;
-- cascade delete from games and shoppingcarts

drop table OnSaleList;
-- cascade delete from games

drop table Games;
-- cascade delete from developers and onSaleList

drop table Developers;
-- has no dependencies

drop table Customers cascade constraints;
-- cascade delete from shopping carts

drop table ShoppingCarts cascade constraints;
-- cascade delete from customers

drop table Members cascade constraints;
-- cascade delete from wishlists

drop table Wishlists cascade constraints;
-- cascade delete from members

drop view capcomgame;

drop view devNameOnly;

CREATE TABLE Developers
    (Name        VARCHAR(40),
     BankAccount VARCHAR(20),
     PRIMARY KEY (Name));

grant select on Developers to public;

CREATE TABLE Games
    (Genre       VARCHAR(20),
     Name        VARCHAR(40),
     GID         INTEGER,
     Price       DECIMAL(19,4),
     ReleaseDate DATE,
     DevName     VARCHAR(40) NOT NULL,
     PRIMARY KEY (GID),
     FOREIGN KEY (DevName)   REFERENCES Developers(Name)
                             ON DELETE CASCADE
                             -- ON UPDATE CASCADE
                             );

CREATE TRIGGER updateCascadeDevNameInGames
AFTER UPDATE OF Name ON Developers
for each row
begin
    UPDATE Games
    Set DevName = :new.Name
    Where DevName = :old.Name;
end;
/

grant select on Games to public;

commit;

CREATE TABLE Customers
    (Email       VARCHAR(40),
     BankAccount VARCHAR(20),
     SID         INTEGER UNIQUE,
     PRIMARY KEY (Email));

grant select on Customers to public;

commit;

CREATE TABLE ShoppingCarts
    (SID         INTEGER UNIQUE,
     Email       VARCHAR(40) NOT NULL,
     PRIMARY KEY (SID, Email));

grant select on ShoppingCarts to public;

ALTER TABLE Customers
ADD CONSTRAINT CustomerFK
FOREIGN KEY (SID) REFERENCES ShoppingCarts(SID) DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE ShoppingCarts
ADD CONSTRAINT CartFK
FOREIGN KEY (Email) REFERENCES Customers(Email)
                         ON DELETE CASCADE
                         DEFERRABLE INITIALLY DEFERRED;


commit;

CREATE TABLE Members
    (Email       VARCHAR(40),
     Username    VARCHAR(20),
     Password    VARCHAR(20),
     WID         INTEGER UNIQUE,
     PRIMARY KEY (Email));

grant select on Members to public;

commit;

CREATE TABLE Wishlists
    (WID         INTEGER UNIQUE,
     Email       VARCHAR(40) NOT NULL,
     PRIMARY KEY (WID, Email));

grant select on Wishlists to public;

ALTER TABLE Members
ADD CONSTRAINT MembersFK
FOREIGN KEY (WID) REFERENCES Wishlists(WID) DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE Wishlists
ADD CONSTRAINT WishlistsFK
FOREIGN KEY (Email) REFERENCES Members(Email)
                         ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED;

commit;

CREATE TABLE OnSaleList
    (EventIndex  INTEGER,
     OGID        INTEGER,
     SalePrice   DECIMAL(19,4),
     StartDate   DATE,
     EndDate     DATE,
     PRIMARY KEY (EventIndex),
     FOREIGN KEY (OGID) REFERENCES Games(GID)
                        ON DELETE CASCADE);

grant select on OnSaleList to public;

commit;

CREATE TABLE AddRemoveFromCart
    (CGID        INTEGER,
     SID         INTEGER,
     PRIMARY KEY (CGID, SID),
     FOREIGN KEY (CGID) REFERENCES Games(GID)
                        ON DELETE CASCADE,
     FOREIGN KEY (SID)  REFERENCES ShoppingCarts(SID)
                        ON DELETE CASCADE);

grant select on AddRemoveFromCart to public;

commit;

CREATE TABLE AddRemoveFromWishlist
    (WGID         INTEGER,
     WID          INTEGER,
     PRIMARY KEY (WGID, WID),
     FOREIGN KEY (WGID) REFERENCES Games(GID)
                        ON DELETE CASCADE,
     FOREIGN KEY (WID) REFERENCES Wishlists(WID)
                       ON DELETE CASCADE);

grant select on AddRemoveFromWishlist to public;

commit;

CREATE TABLE Purchases
    (Email       VARCHAR(40),
     GID         INTEGER,
     PRIMARY KEY (Email, GID),
     FOREIGN KEY (Email) REFERENCES Customers(Email)
                         ON DELETE CASCADE
                         -- ON UPDATE CASCADE
                         ,
     FOREIGN KEY (GID)   REFERENCES Games(GID)
                         ON DELETE CASCADE);

grant select on Purchases to public;

CREATE TRIGGER removePurchasedGameFromCart
AFTER INSERT ON Purchases
FOR EACH ROW
BEGIN
    DELETE FROM AddRemoveFromCart arfc
    where arfc.CGID = :new.GID
    and
    arfc.SID = (select SID from Customers c where c.email = :new.Email);
END;
/

CREATE TRIGGER removePurchasedGameFromWL
AFTER INSERT ON Purchases
FOR EACH ROW
BEGIN
    DELETE FROM AddRemoveFromWishlist arfw
    where arfw.WGID = :new.GID
    and
    arfw.WID = (select WID from Members m where m.email = :new.Email);
END;
/

commit;

CREATE TABLE Friends
    (MyEmail     VARCHAR(40),
     FriendEmail VARCHAR(40),
     PRIMARY KEY (MyEmail, FriendEmail),
     FOREIGN KEY (MyEmail)     REFERENCES Members(Email)
                               ON DELETE CASCADE,
     FOREIGN KEY (FriendEmail) REFERENCES Members(Email)
                               ON DELETE CASCADE);

grant select on Friends to public;

commit;

CREATE TABLE Reviews
    (RID        INTEGER,
    Rating      INTEGER ,
    GID         INTEGER ,
    Intro       VARCHAR(80),
    Link        VARCHAR(80),
    PRIMARY KEY (RID),
    FOREIGN KEY (GID)   REFERENCES Games(GID)
                        ON DELETE CASCADE);

grant select on Reviews to public;

commit;

INSERT INTO Developers
VALUES ('Capcom', 'CAP1111');

INSERT INTO Developers
VALUES ('Rockstar', 'ROC1111');

INSERT INTO Developers
VALUES ('Blizzard', 'BLZ1111');

INSERT INTO Developers
VALUES ('Valve', 'VAL1111');

INSERT INTO Developers
VALUES ('Bethesda', 'BET1111');

INSERT INTO Developers
VALUES ('EA', 'EA1111');

INSERT INTO Developers
VALUES ('PUBG Corporation', 'PUB1111');

INSERT INTO Developers
VALUES ('Epic Games', 'EPI1111');

INSERT INTO Developers
VALUES ('Dontnod Entertainment', 'DON1111');

INSERT INTO Developers
VALUES ('Visual Concepts', 'VIS1111');

INSERT INTO Developers
VALUES ('Firaxis Games', 'FIR1111');


INSERT INTO Games
VALUES ('Survival Horror', 'Resident Evil 7', 1001, 39.99, to_date('2017-01-24', 'yyyy/mm/dd'), 'Capcom');

INSERT INTO Games
VALUES ('Survival Horror', 'Resident Evil 6', 1002, 29.99, '2012-10-02', 'Capcom');

INSERT INTO Games
VALUES ('Survival Horror', 'Resident Evil 5', 1003, 19.99, '2009-03-05', 'Capcom');

INSERT INTO Games
VALUES ('Survival Horror', 'Resident Evil 4', 1004, 19.99, '2005-01-11', 'Capcom');

INSERT INTO Games
VALUES ('Action', 'Devil May Cry 4', 1005, 19.99, '2008-01-31', 'Capcom');

INSERT INTO Games
VALUES ('Action-Adventure', 'Red Dead Redemption 2', 1006, 79.99, '2018-10-26', 'Rockstar');

INSERT INTO Games
VALUES ('Action-Adventure', 'Grand Theft Auto V', 1007, 29.99, '2013-09-11', 'Rockstar');

INSERT INTO Games
VALUES ('Action-Adventure', 'Grand Theft Auto IV', 1008, 19.99, '2008-04-29', 'Rockstar');

INSERT INTO Games
VALUES ('Action', 'Battlefield V', 1009, 59.99, '2018-11-15', 'EA');

INSERT INTO Games
VALUES ('Action', 'Overwatch', 1010, 49.99, '2010-11-11', 'Blizzard');

INSERT INTO Games
VALUES ('Action', 'Counter Strike: Global Offensive', 1011, 19.99, '2016-11-11', 'Valve');

INSERT INTO Games
VALUES ('Action', 'PlayerUnknown''s Battlegrounds', 1012, 39.99, '2016-11-11', 'PUBG Corporation');

INSERT INTO Games
VALUES ('Action', 'Fortnite', 1013, 39.99, '2016-11-11', 'Epic Games');

INSERT INTO Games
VALUES ('Adventure', 'Life Is Strange 2', 1014, 7.99, '2018-09-27', 'Dontnod Entertainment');

INSERT INTO Games
VALUES ('Sports', 'FIFA 19', 1015, 79.76, '2018-09-28', 'EA');

INSERT INTO Games
VALUES ('Sports', 'NBA2K19', 1016, 77.99, '2018-09-07', 'Visual Concepts');

INSERT INTO Games
VALUES ('Strategy', 'Hearthstone', 1017, 0.00, '2014-03-11', 'Blizzard');

INSERT INTO Games
VALUES ('Strategy', 'Civilization VI', 1018, 20.99, '2014-10-21', 'Firaxis Games');

INSERT INTO Games
VALUES ('Simulation', 'The Sims 4', 1019, 59.99, '2014-09-02', 'EA');

INSERT INTO Games
VALUES ('Role-Playing', 'The Elder Scrolls V: Skyrim', 1020, 39.99, '2011-11-11', 'Bethesda');


INSERT INTO Customers
VALUES ('smithbbb@hotmail.com', 'SMI1111', 1);

INSERT INTO Customers
VALUES ('annawang@gmail.com', 'ANN1111', 2);

INSERT INTO Customers
VALUES ('misaki@yahoo.jp', 'MIS1111', 3);

INSERT INTO Customers
VALUES ('test@test.com', 'TES1111', 4);

INSERT INTO Customers
VALUES ('test2@test.com', 'TES1111', 5);

INSERT INTO Customers
VALUES ('test3@test.com', 'TES1111', 6);

INSERT INTO Customers
VALUES ('test4@test.com', 'TES1111', 7);

INSERT INTO Customers
VALUES ('userPurchasedAll@query.com', 'buyThemAll', 8);

INSERT INTO Members
VALUES ('annawang2@gmail.com', 'annawang','123456', 1);

INSERT INTO Members
VALUES ('justanotheremail@hotmail.com', 'misaki666','aaabbb', 2);

INSERT INTO Members
VALUES ('stevejobs@gmail.com', 'stevejobs','123456', 3);

INSERT INTO Members
VALUES ('timcook@gmail.com', 'timcook','123456', 4);

INSERT INTO Members
VALUES ('billgates@gmail.com', 'billgates','123456', 5);

INSERT INTO Members
VALUES ('elonmusk@gmail.com', 'elonmusk','123456', 6);

INSERT INTO Members
VALUES ('sundarpichai@gmail.com', 'sundarpichai','123456', 7);

INSERT INTO Members
VALUES ('jackma@gmail.com', 'mayun','123456', 8);

INSERT INTO Wishlists
VALUES (1,'annawang2@gmail.com');

INSERT INTO Wishlists
VALUES (2,'justanotheremail@hotmail.com');

INSERT INTO Wishlists
VALUES (3,'stevejobs@gmail.com');

INSERT INTO Wishlists
VALUES (4,'timcook@gmail.com');

INSERT INTO Wishlists
VALUES (5,'billgates@gmail.com');

INSERT INTO Wishlists
VALUES (6,'elonmusk@gmail.com');

INSERT INTO Wishlists
VALUES (7,'sundarpichai@gmail.com');

INSERT INTO Wishlists
VALUES (8,'jackma@gmail.com');

INSERT INTO OnSaleList
VALUES (1,1001,29.99,'2018-11-11', '2018-12-12');

INSERT INTO OnSaleList
VALUES (2,1002,15.99,'2018-11-11', '2018-12-12');

INSERT INTO OnSaleList
VALUES (3,1003,7.99,'2018-11-11', '2018-12-12');

INSERT INTO OnSaleList
VALUES (4,1004,7.99,'2018-11-11', '2018-12-12');

INSERT INTO ShoppingCarts
VALUES (1,'smithbbb@hotmail.com');

INSERT INTO ShoppingCarts
VALUES (2,'annawang@gmail.com');

INSERT INTO ShoppingCarts
VALUES (3,'misaki@yahoo.jp');

INSERT INTO ShoppingCarts
VALUES (4,'test@test.com');

INSERT INTO ShoppingCarts
VALUES (5,'test2@test.com');

INSERT INTO ShoppingCarts
VALUES (6,'test3@test.com');

INSERT INTO ShoppingCarts
VALUES (7,'test4@test.com');

INSERT INTO ShoppingCarts
VALUES (8,'userPurchasedAll@query.com');

INSERT INTO AddRemoveFromCart
VALUES (1006,1);

INSERT INTO AddRemoveFromCart
VALUES (1007,1);

INSERT INTO AddRemoveFromCart
VALUES (1006,2);

INSERT INTO AddRemoveFromCart
VALUES (1007,2);

INSERT INTO AddRemoveFromCart
VALUES (1008,2);

INSERT INTO AddRemoveFromCart
VALUES (1009,2);

INSERT INTO AddRemoveFromCart
VALUES (1011,3);

INSERT INTO AddRemoveFromCart
VALUES (1006,4);

INSERT INTO AddRemoveFromCart
VALUES (1007,4);

INSERT INTO AddRemoveFromCart
VALUES (1008,4);

INSERT INTO AddRemoveFromCart
VALUES (1009,5);

INSERT INTO AddRemoveFromCart
VALUES (1011,5);

INSERT INTO AddRemoveFromCart
VALUES (1012,6);

INSERT INTO AddRemoveFromWishlist
VALUES (1003,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1014,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1005,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1016,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1015,2);

INSERT INTO AddRemoveFromWishlist
VALUES (1016,2);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1001);

INSERT INTO Purchases
VALUES ('annawang@gmail.com',1001);

INSERT INTO Purchases
VALUES ('misaki@yahoo.jp',1001);

INSERT INTO Purchases
VALUES ('test2@test.com',1001);

INSERT INTO Purchases
VALUES ('test3@test.com',1001);

INSERT INTO Purchases
VALUES ('test4@test.com',1001);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1002);

INSERT INTO Purchases
VALUES ('annawang@gmail.com',1002);

INSERT INTO Purchases
VALUES ('misaki@yahoo.jp',1002);

INSERT INTO Purchases
VALUES ('test2@test.com',1002);

INSERT INTO Purchases
VALUES ('test3@test.com',1002);

INSERT INTO Purchases
VALUES ('test4@test.com',1002);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1003);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1004);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1005);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1006);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1020);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1001);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1002);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1003);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1004);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1005);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1006);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1007);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1008);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1009);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1010);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1011);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1012);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1013);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1014);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1015);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1016);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1017);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1018);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1019);

INSERT INTO Purchases
VALUES ('userPurchasedAll@query.com',1020);

INSERT INTO Purchases
VALUES ('test@test.com',1001);

INSERT INTO Purchases
VALUES ('test@test.com',1002);

INSERT INTO Purchases
VALUES ('test@test.com',1003);

INSERT INTO Purchases
VALUES ('test@test.com',1004);

INSERT INTO Friends
VALUES ('justanotheremail@hotmail.com','annawang2@gmail.com');

INSERT INTO Friends
VALUES ('timcook@gmail.com','billgates@gmail.com');

INSERT INTO Friends
VALUES ('timcook@gmail.com','elonmusk@gmail.com');

INSERT INTO Friends
VALUES ('elonmusk@gmail.com','billgates@gmail.com');

INSERT INTO Friends
VALUES ('billgates@gmail.com','sundarpichai@gmail.com');

INSERT INTO Friends
VALUES ('billgates@gmail.com','elonmusk@gmail.com');

create view capcomgame
as select name, devname from games where devname = 'Capcom';

create view devNameOnly
as select unique name from Developers;

COMMIT;