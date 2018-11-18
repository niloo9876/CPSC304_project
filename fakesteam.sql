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
     CONSTRAINT GamesFK_Developers
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
     MID         INTEGER,
     Username    VARCHAR(20),
     Password    VARCHAR(20),
     WID         INTEGER UNIQUE,
     PRIMARY KEY (Email,MID),
     CONSTRAINT MembersFK_Customer
     FOREIGN KEY (Email) REFERENCES Customers(Email)
                         ON DELETE CASCADE
     );

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
     GID         INTEGER,
     SalePrice   DECIMAL(19,4),
     StartDate   DATE,
     EndDate     DATE,
     PRIMARY KEY (EventIndex),
     CONSTRAINT OnSaleListFK_Game
     FOREIGN KEY (GID) REFERENCES Games(GID)
                       ON DELETE CASCADE);

grant select on OnSaleList to public;

commit;

CREATE TABLE AddRemoveFromCart
    (GID         INTEGER,
     SID         INTEGER,
     PRIMARY KEY (GID, SID),
     CONSTRAINT AddRemoveFromCartFK_Games
     FOREIGN KEY (GID) REFERENCES Games(GID)
                       ON DELETE CASCADE,
     CONSTRAINT AddRemoveFromCartFK_ShoppingCarts
     FOREIGN KEY (SID) REFERENCES ShoppingCarts(SID)
                       ON DELETE CASCADE);

grant select on AddRemoveFromCart to public;

commit;

CREATE TABLE AddRemoveFromWishlist
    (GID         INTEGER,
     WID         INTEGER,
     PRIMARY KEY (GID, WID),
     CONSTRAINT AddRemoveFromWishlistFK_Games
     FOREIGN KEY (GID) REFERENCES Games(GID)
                       ON DELETE CASCADE,
     CONSTRAINT AddRemoveFromWishlistFK_Wishlists
     FOREIGN KEY (WID) REFERENCES Wishlists(WID)
                       ON DELETE CASCADE);

grant select on AddRemoveFromWishlist to public;

commit;

CREATE TABLE Purchases
    (Email       VARCHAR(40),
     GID         INTEGER,
     PRIMARY KEY (Email, GID),
     CONSTRAINT PurchasesFK_Customers
     FOREIGN KEY (Email) REFERENCES Customers(Email)
                         ON DELETE CASCADE
                         -- ON UPDATE CASCADE
                         ,
     CONSTRAINT PurcahsesFK_Games
     FOREIGN KEY (GID)   REFERENCES Games(GID)
                         ON DELETE CASCADE);

grant select on Purchases to public;

commit;

CREATE TRIGGER removePurchasedGameFromCart
AFTER INSERT on Purchases
FOR EACH ROW
BEGIN
DELETE FROM AddRemoveFromCart arfc
where
arfc.GID = :new.GID
and
arfc.SID = (select SID from Customers c where c.email = :new.Email);
END;
/


CREATE TABLE Friends
    (MyEmail     VARCHAR(40),
     FriendEmail VARCHAR(40),
     PRIMARY KEY (MyEmail, FriendEmail),
     CONSTRAINT FriendsFK_MyEmail
     FOREIGN KEY (MyEmail)     REFERENCES Members(Email)
                               ON DELETE CASCADE,
     CONSTRAINT FriendsEK_FriendEmail
     FOREIGN KEY (FriendEmail) REFERENCES Members(Email)
                               ON DELETE CASCADE);

grant select on Friends to public;

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
VALUES (1012,3);

INSERT INTO AddRemoveFromWishlist
VALUES (1013,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1014,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1015,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1016,1);

INSERT INTO AddRemoveFromWishlist
VALUES (1015,2);

INSERT INTO AddRemoveFromWishlist
VALUES (1016,2);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1001);

INSERT INTO Purchases
VALUES ('smithbbb@hotmail.com',1002);

INSERT INTO Friends
VALUES ('justanotheremail@hotmail.com','annawang2@gmail.com');


COMMIT;