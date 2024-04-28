-- Active: 1712127514804@@127.0.0.1@3306@hungerstation

CREATE DATABASE HungerStation
    DEFAULT CHARACTER SET = 'utf8mb4';

USE HungerStation;

-- FIX THE DIAGRAM, get rid of spaces in the ERD
-- Should add 'WHERE' checks, 
-- Username must be more than 8 char
-- Password must have Uppercase char, Number
-- Phone Number must be valid, 10 digit >
-- Phone Number must be valid, begins with 00
-- AGE MUST BE ABOVE 18, etc.

CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(30) NOT NULL UNIQUE,
    Password VARCHAR(30) NOT NULL,
    Email TEXT NOT NULL UNIQUE,
    Name TEXT,
    Address VARCHAR(50),
    PhoneNumber INT UNIQUE);

-- email -> not null+unique, phone number unique null
-- address -> null

-- Set Email column to NOT NULL and UNIQUE
-- ALTER TABLE Customer
-- MODIFY Email TEXT NOT NULL UNIQUE;

-- Set PhoneNumber column to UNIQUE and allow NULL values
-- ALTER TABLE Customer
-- MODIFY PhoneNumber INT UNIQUE;

-- Allow Address column to have NULL values
-- ALTER TABLE Customer
-- MODIFY Address VARCHAR(50);
--
CREATE TABLE MenuCategory (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    CategoryName VARCHAR(30) NOT NULL DEFAULT 'Unspecified'
);

CREATE TABLE MenuItem (
    ItemID INT PRIMARY KEY AUTO_INCREMENT,
    CategoryID INT NOT NULL,
    ItemName VARCHAR(30) NOT NULL,
    Description TEXT,
    ImageURL TEXT,
    Price REAL NOT NULL DEFAULT 2.50,
    AvailabilityStatus BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (CategoryID) REFERENCES MenuCategory(CategoryID)
);

INSERT INTO `menuitem` (`ItemID`, `CategoryID`, `ItemName`, `Description`, `ImageURL`, `Price`, `AvailabilityStatus`) VALUES
(1, 1, 'Greek Salad', 'A traditional Greek salad consists of sliced cucumbers, tomatoes, green bell pepper, red onion, olives, and feta cheese. ', 'https://www.foodandwine.com/thmb/q9tccMZgV9aifYtmlvh9qcPmb_8=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/Greek-Salad-Romaine-FT-RECIPE1222-8a49c63ede714dfb8fdc0c35088fcd18.jpg', 10, 1),
(2, 2, 'Pasta Carbonara', 'spaghetti (long thin strands of pasta) with bacon and a creamy sauce made from eggs, Pecorino or Parmesan and black pepper', 'https://www.adventuresofanurse.com/wp-content/uploads/2017/01/Pasta-Carbonara-Cheesecake-Factory-735x489.jpg', 30, 1),
(3, 1, 'Pull-Apart Buffalo Chicken Sli', 'These sliders make buffalo chicken even easier by using ground chicken for the tasty, cheesy filling. It\'s a dish you\'ll want to serve on game day and beyond!', 'https://hips.hearstapps.com/hmg-prod/images/easy-appetizers-pull-apart-buffalo-chicken-sliders-662bded649f79.jpeg?crop=1xw:1xh;center,top&resize=980:*', 10, 0),
(4, 1, 'Guacamole', 'Guacamole is an avocado-based dip, spread, or salad first developed in Mexico. In addition to its use in modern Mexican cuisine, it has become part of international cuisine as a dip, condiment and salad ingredient.', 'https://assets.tmecosys.com/image/upload/t_web767x639/img/recipe/ras/Assets/7DD941F0-7E17-4DBB-A778-90328C0AC000/Derivates/254D6349-1A37-47B1-A490-BC4B5013AECA.jpg', 10, 0),
(5, 1, 'Pull-Apart Cheese Bread', 'Any appetizer that includes cheese and bread is an instant hit in our books! This easy recipe is perfect for crowd-sharing as, before baking, it’s sliced in a pretty (and functional) diagonal pattern that yields perfect, bite-size portions of cheese and pesto-filled goodness.', 'https://hips.hearstapps.com/hmg-prod/images/easy-appetizers-pull-apart-cheese-bread-6581d589ca345.jpeg?crop=1xw:1xh;center,top&resize=980:*', 10, 1),
(6, 2, 'Braised Chicken Legs With Grap', 'There\'s nothing wrong with defaulting to chicken when you\'re trying to think of dinner party ideas. The key is to select a truly special chicken recipe, like this easy sweet-and-spicy braise, made with ribbons of fennel and juicy table grapes. You\'ll want to have a loaf of bread on the side for sopping up the sauce.', 'https://assets.epicurious.com/photos/5f737a125a7e264184aab1b4/1:1/w_1920%2Cc_limit/ChickenGrapesFennel_HEROv2_12175.jpg', 10, 1),
(7, 2, 'Double-Stack Mushroom and Chic', 'Crispy seasoned chicken breast, topped with mandatory melted cheese, piled onto soft rolls with onion, avocado, lettuce, tomato and garlic mayo and mushrooms.', 'https://assets.epicurious.com/photos/60d1e9fbd62cfdf9e277542e/1:1/w_1920%2Cc_limit/ChickenMushroomBurger_RECIPE_061721_18256.jpg', 20, 1),
(8, 2, 'Mast Biryani (Grand Vegetable ', 'This is the main course to make for special occasions, especially with vegetarians at your table. It features a rainbow of colors, flavors, and textures, thanks to creamy paneer, chickpeas, roasted beets, sweet potatoes, and a citrusy coconut and cilantro sauce.', 'https://assets.epicurious.com/photos/5fa44b985cbe6116eb406a35/1:1/w_1920%2Cc_limit/grand-vegetable-biryani-recipe-110520.jpg', 50, 1),
(9, 2, 'Slow-Roasted Salmon in Parchme', 'This classic technique gets a modern punch of flavor from briny olives and capers, sweet raisins, a splash of rum, and a squeeze of bright lime juice.', 'https://assets.epicurious.com/photos/5a3002b504072728dadcd315/1:1/w_1920%2Cc_limit/slow-roasted-salmon-in-parchment-paper-recipe-BA-121217.jpg', 40, 1),
(10, 3, 'Creamed Spinach', 'Wilted spinach is mixed through a silky smooth white sauce, flavoured with sautéed onion and garlic, then served with parmesan cheese.', 'https://healthyrecipesblogs.com/wp-content/uploads/2021/11/creamed-spinach-featured-2022.jpg', 15, 0),
(11, 3, 'Mac & Cheese', 'Mac and cheese is a rich and creamy dish consisting of macaroni pasta mixed with a cheesy sauce.', 'https://upload.wikimedia.org/wikipedia/commons/4/44/Original_Mac_n_Cheese_.jpg', 15, 1),
(12, 3, 'Garlic Bread', 'Garlic bread (also called garlic toast) consists of bread (usually a baguette, sour dough, or bread such as ciabatta), topped with garlic and occasionally olive oil or butter and may include additional herbs, such as oregano or chives.', 'https://i.ytimg.com/vi/ZxZO9wdOHPU/maxresdefault.jpg', 20, 1),
(13, 3, 'Garlic Mashed Potatoes', 'Made with Yukon gold potatoes and roasted garlic, these garlic mashed potatoes are creamy, rich, and flavorful.', 'https://www.allrecipes.com/thmb/vr52EqIF1vxGN-s6GosKt-H3u10=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/4579989-roasted-garlic-parmesan-mashed-potatoes-naples34102-4x3-1-55c867a9c00c4fe38af3f4486648dede.jpg', 15, 1),
(14, 4, 'Texas Sheet Cake', 'his chocolate cake is rich, extra-fudgy, and topped with plenty of toasty pecans. It\'s a classic dessert for very good reason: it was made for chocolate lovers.', 'https://www.allrecipes.com/thmb/GSco4zzXiyTi96oJEZiq-Lacf18=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/278981-grandmas-chocolate-texas-sheetcake-3x4-378-copy-1a1b1096c4e544f394a2bc7bb2896379.jpg', 8, 1),
(15, 4, 'Piña Colada Lasagna', 'It\'s got a base of coconut and graham cracker, layered with a coconut cream cheese, shortbread cookies, and pineapple Jell-O, echoing its namesake frozen drink.', 'https://forum.recipes.net/attachments/pina-colada-lasagna-jpg.2387/', 25, 1),
(16, 4, 'Lime Pie Mousse', 'This take on Key lime pie has all of the refreshing tartness and buttery crumble of the classic dessert, but in an adorable, individual container. ', 'https://hips.hearstapps.com/hmg-prod/images/key-lime-pie-mousse-secondary-64d3a4ed6ab2a.jpg', 16, 1),
(17, 4, 'Coffee Cookies \'N\' Cream Ice C', 'folded in Oreos, caramel sauce, and a touch of instant coffee for a caffeinated kick.', 'https://hips.hearstapps.com/hmg-prod/images/210331-delish-no-churn-ice-cream-21561-eb-1622839116.jpg', 9, 1),
(18, 4, 'Triple-Chocolate Trifle', 'Layers of complementary flavors make this trifle really pop. The tahini brings a subtle nutty flavor, while the dark rum adds warmth. ', 'https://www.dinnerin321.com/wp-content/uploads/2022/12/E7BD85D6-4F83-43CE-9A4C-482620E92855-scaled.jpeg', 12, 1),
(19, 5, 'Coca Cola', NULL, 'https://www.beveragedaily.com/var/wrbm_gb_food_pharma/storage/images/_aliases/wrbm_large/publications/food-beverage-nutrition/beveragedaily.com/article/2019/07/12/diet-coke-helps-boost-coca-cola-s-brand-value-brand-finance-rankings/9912727-1-eng-GB/Diet-Coke-helps-boost-Coca-Cola-s-brand-value-Brand-Finance-rankings.jpg', 2.5, 1),
(20, 5, 'Sprite', NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThTdbCl4A9Cw4IIJXKckyvIZPyumVKgVkNdw&s', 2.5, 1),
(21, 5, 'Bonaqua Sparkling', NULL, 'https://assets.epicurious.com/photos/625f217ba5cb57e556502ffe/16:9/w_2560%2Cc_limit/genki-sparking-water_HERO_041322_7485_VOG_final.jpg', 2.5, 1),
(22, 5, 'Hot Chocolate', NULL, 'https://www.foodandwine.com/thmb/V1OEgtLQGUv_w2Fvm40WMLsJ4rk=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/Indulgent-Hot-Chocolate-FT-RECIPE0223-fd36942ef266417ab40440374fc76a15.jpg', 6, 1),
(23, 5, 'Iced Coffee', NULL, 'https://img.taste.com.au/UHFv39Ks/taste/2020/05/jun20_vietnamese-iced-coffee-161761-1.jpg', 7, 1),
(25, 3, 'French Fries', 'Freakin\' Hot Fries. A 6 ounce serving of piping-hot french fries, crispy and more flavorful than any at those fast food joints.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8NiMCkPKs6TyuWgFYnhm6NWmPSbB543IroZBJMK5vEw&s', 7, 1),
(26, 1, 'Football Fest Empanadas', 'Classic empanadas from South America are pastries stuffed with beef or chicken, usually fried. That doesn\'t mean \"classic\" never changes', 'https://www.tasteofhome.com/wp-content/uploads/2018/01/exps111455_TH2237243F10_13_4b_WEB-2.jpg?fit=700,700', 11, 1);


-- RENAME TABLE - can't use ORDER, changed to ORDERS NOW
-- OrderStatus = delivered yes/no
CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    OrderDateTime DATETIME NOT NULL,
    Price REAL NOT NULL DEFAULT 0.00,
    OrderStatus BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

-- Payment details
CREATE TABLE Payment (
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT NOT NULL,
    CustomerID INT NOT NULL,
    Price REAL NOT NULL DEFAULT 0.00,
    PaymentMethod VARCHAR(30) NOT NULL,
    CardNumber VARCHAR(16),
    ExpiryDate VARCHAR(5),
    CVV INT(3),
    CONSTRAINT check_numeric_only CHECK (CardNumber REGEXP '^[0-9]+$'),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

-- default price for items
-- RENAME to ITEM
-- ADD STOCK COLUMN, HOW MANY OF THESE ITEMS AVAILIABLE?
-- ITEMID ARROW IS MISSING TO FOREIGN KEY
CREATE TABLE OrderItem (
    OrderItemID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT NOT NULL,
    ItemID INT NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ItemID) REFERENCES MenuItem(ItemID)
);