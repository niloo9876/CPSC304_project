BEGIN TRANSACTION;

/* Create a table called NAMES */

CREATE TABLE Developers
    (Name        CHAR(40),
     BankAccount CHAR(10),
     PRIMARY KEY (Name));

CREATE TABLE Games
    (Genre       CHAR(10),
     Name        CHAR(20),
     GID         INTEGER,
     Price       DECIMAL(19,4),
     ReleaseDate DATE,
     DevName     CHAR(10) NOT NULL,
     SalePrice   DECIMAL(19,4),
     PRIMARY KEY (GID),
     FOREIGN KEY (DevName)   REFERENCES Developers(Name)
                             ON DELETE CASCADE
                             ON UPDATE CASCADE,
     FOREIGN KEY (SalePrice) REFERENCES OnSaleLists(SalePrice)
                             ON DELETE NO ACTION
                             ON UPDATE CASCADE);

CREATE TABLE Customers
    (Email       CHAR(40),
     BankAccount CHAR(10),
     SID         INTEGER UNIQUE,
     PRIMARY KEY (Email),
     FOREIGN KEY (SID) REFERENCES ShoppingCarts(SID));

CREATE TABLE Members
    (MID         INTEGER,
     Username    CHAR(10),
     Password    CHAR(20),
     WID         INTEGER UNIQUE,
     PRIMARY KEY (MID),
     FOREIGN KEY (WID) REFERENCES Wishlists(WID));

CREATE TABLE Wishlists         
    (WID         INTEGER,       
     MID         INTEGER NOT NULL,
     PRIMARY KEY (WID, MID),
     FOREIGN KEY (MID) REFERENCES Members(MID)
                       ON DELETE CASCADE);

CREATE TABLE OnSaleLists
    (GID         INTEGER,
     EventIndex  INTEGER,
     SalePrice   DECIMAL(19,4),
     StartDate   DATE,
     EndDate     DATE,
     PRIMARY KEY (EventIndex),
     FOREIGN KEY (GID) REFERENCES Games(GID)
                       ON DELETE CASCADE);

CREATE TABLE ShoppingCarts
    (SID         INTEGER,
     Email       CHAR(40) NOT NULL,
     PRIMARY KEY (SID, Email),  
     FOREIGN KEY (Email) REFERENCES Customers(Email)
                         ON DELETE CASCADE
                         ON UPDATE CASCADE);

CREATE TABLE AddRemoveFromCart
    (GID         INTEGER,
     SID         INTEGER,
     PRIMARY KEY (GID, SID),
     FOREIGN KEY (GID) REFERENCES Games(GID)
                       ON DELETE CASCADE,
     FOREIGN KEY (SID) REFERENCES ShoppingCarts(SID)
                       ON DELETE CASCADE);

CREATE TABLE AddRemoveFromWishlist 
    (GID         INTEGER,
     WID         INTEGER,
     PRIMARY KEY (GID, WID),
     FOREIGN KEY (GID) REFERENCES Games(GID)
                       ON DELETE CASCADE,
     FOREIGN KEY (WID) REFERENCES Wishlists(WID)
                       ON DELETE CASCADE);

CREATE TABLE Purchases
    (Email       CHAR(40),
     GID         INTEGER,
     PRIMARY KEY (Email, GID),
     FOREIGN KEY (Email) REFERENCES Customers(Email)
                         ON DELETE CASCADE
                         ON UPDATE CASCADE,
     FOREIGN KEY (GID)   REFERENCES Games(GID)
                         ON DELETE CASCADE);

CREATE TABLE Friends
    (MyMID       INTEGER,
     FriendMID   INTEGER,
     PRIMARY KEY (MyMID, FriendMID),
     FOREIGN KEY (MyMID)     REFERENCES Members(MID)
                             ON DELETE CASCADE,
     FOREIGN KEY (FriendMID) REFERENCES Members(MID)
                             ON DELETE CASCADE);


/* Create few records in this table */

INSERT INTO Developers
VALUES ("Capcom", "CAP1111");

INSERT INTO Developers
VALUES ("Rockstar", "ROC1111");

INSERT INTO Developers
VALUES ("Blizzard", "BLZ1111");

INSERT INTO Developers
VALUES ("John", "JOH1111");


INSERT INTO Games
VALUES ("Action", "Devil May Cry 3", 0001, 59.99, 2001-11-11, "Capcom", NULL);

INSERT INTO Games
VALUES ("Advanture", "Red Dead Redemption 2", 0002, 79.99, 2018-10-26, "Rockstar", NULL);

INSERT INTO Games
VALUES ("FPS", "Overwatch", 0003, 49.99, 2010-11-11, "Blizzard", 29.99);

INSERT INTO Games
VALUES ("Indie", "I made it up", 0004, 19.99, 2001-11-11, "John", 9.99);


INSERT INTO Customers
VALUES ("smithbbb@hotmail.com", "SMI1111", 0001);

INSERT INTO Customers
VALUES ("annawang@gmail.com", "ANN1111", 0002);

INSERT INTO Customers
VALUES ("misaki@yahoo.jp", "MIS1111", 0003);

INSERT INTO Members
VALUES (1, "annawang","123456", 0001);

INSERT INTO Members
VALUES (2, "misaki666","aaabbb", 0002);

INSERT INTO Wishlists
VALUES (1,1);

INSERT INTO Wishlists
VALUES (2,2);

INSERT INTO OnSaleLists
VALUES (3,1,29.99,2018-11-11, 2018-12-12);

INSERT INTO OnSaleLists
VALUES (4,2,9.99,2018-11-11, 2018-12-12);

INSERT INTO ShoppingCarts
VALUES (1,"smithbbb@hotmail.com");

INSERT INTO ShoppingCarts
VALUES (2,"annawang@gmail.com");

INSERT INTO ShoppingCarts
VALUES (3,"misaki@yahoo.jp");

INSERT INTO AddRemoveFromCart
VALUES (1,1);

INSERT INTO AddRemoveFromCart
VALUES (2,1);

INSERT INTO AddRemoveFromCart
VALUES (1,2);

INSERT INTO AddRemoveFromCart
VALUES (2,2);

INSERT INTO AddRemoveFromCart
VALUES (3,2);

INSERT INTO AddRemoveFromCart
VALUES (4,2);

INSERT INTO AddRemoveFromCart
VALUES (2,3);

INSERT INTO AddRemoveFromCart
VALUES (3,3);

INSERT INTO AddRemoveFromWishlist
VALUES (1,1);

INSERT INTO AddRemoveFromWishlist
VALUES (2,1);

INSERT INTO AddRemoveFromWishlist
VALUES (3,1);

INSERT INTO AddRemoveFromWishlist
VALUES (4,1);

INSERT INTO AddRemoveFromWishlist
VALUES (2,2);

INSERT INTO AddRemoveFromWishlist
VALUES (3,2);

INSERT INTO Purchases
VALUES ("smithbbb@hotmail.com",3);

INSERT INTO Purchases
VALUES ("smithbbb@hotmail.com",4);

INSERT INTO Friends
VALUES (1,2);


COMMIT;

/* Display all the records from the table */
SELECT * FROM customers;
SELECT * FROM members;
