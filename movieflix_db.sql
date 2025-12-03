-- =====================================================================================
   -- DATABASE: movieflix
   -- DESCRIPTION: Core schema for online movie ticket booking system.
-- =====================================================================================

CREATE DATABASE IF NOT EXISTS movieflix_db;
USE movieflix_db;

-- =====================================================================================
   -- 1. USERS TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS users (
    user_id     INT PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) UNIQUE NOT NULL,
    phone       VARCHAR(15),
    password    VARCHAR(100) NOT NULL,
    role        ENUM('user', 'admin') DEFAULT 'user',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================================================
   -- 2. MOVIES TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS movies (
    movie_id     INT PRIMARY KEY AUTO_INCREMENT,
    title        VARCHAR(200) NOT NULL,
    description  TEXT,
    genre        VARCHAR(100),
    language     VARCHAR(50),
    duration     INT,
    rating       DECIMAL(2,1),
    release_date DATE,
    poster_url   VARCHAR(255),
    trailer_url  VARCHAR(255),
    status       ENUM('now_showing', 'coming_soon', 'archived') DEFAULT 'now_showing'
);

-- =====================================================================================
    -- 3. THEATRES TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS theatres (
    theatre_id    INT PRIMARY KEY AUTO_INCREMENT,
    name          VARCHAR(100) NOT NULL,
    location      VARCHAR(200),
    city          VARCHAR(50),
    total_screens INT
);

-- =====================================================================================
    -- 4. SCREENS TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS screens (
    screen_id    INT PRIMARY KEY AUTO_INCREMENT,
    theatre_id   INT,
    screen_name  VARCHAR(50),
    total_seats  INT,
    FOREIGN KEY (theatre_id) REFERENCES theatres(theatre_id) ON DELETE CASCADE
);

-- =====================================================================================
    -- 5. SEATS TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS seats (
    seat_id     INT PRIMARY KEY AUTO_INCREMENT,
    screen_id   INT,
    seat_number VARCHAR(10),
    seat_type   ENUM('Regular', 'Premium', 'VIP'),
    price       DECIMAL(10,2),
    FOREIGN KEY (screen_id) REFERENCES screens(screen_id) ON DELETE CASCADE
);

-- =====================================================================================
    -- 6. SHOWTIMES TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS showtimes (
    showtime_id INT PRIMARY KEY AUTO_INCREMENT,
    movie_id    INT,
    screen_id   INT,
    show_date   DATE,
    show_time   TIME,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE,
    FOREIGN KEY (screen_id) REFERENCES screens(screen_id) ON DELETE CASCADE
);

-- =====================================================================================
    -- 7. BOOKINGS TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS bookings (
    booking_id    INT PRIMARY KEY AUTO_INCREMENT,
    user_id       INT,
    showtime_id   INT,
    booking_date  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount  DECIMAL(10,2),
    status        ENUM('confirmed', 'cancelled') DEFAULT 'confirmed',
    FOREIGN KEY (user_id)     REFERENCES users(user_id)     ON DELETE CASCADE,
    FOREIGN KEY (showtime_id) REFERENCES showtimes(showtime_id) ON DELETE CASCADE
);

-- =====================================================================================
    -- 8. BOOKED SEATS TABLE
-- =====================================================================================
CREATE TABLE IF NOT EXISTS booked_seats (
    id         INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT,
    seat_id    INT,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE,
    FOREIGN KEY (seat_id)    REFERENCES seats(seat_id)       ON DELETE CASCADE
);

-- =====================================================================================
    -- INSERT: DEFAULT ADMIN USER
-- =====================================================================================
INSERT INTO users (name, email, phone, password, role) VALUES 
('Admin User', 'admin@movieflix.com', '1234567890', 'adminPassword', 'admin');

-- =====================================================================================
   -- INSERT: MOVIE RECORDS (20 MOVIES)
-- =====================================================================================
INSERT INTO movies (title, description, genre, language, duration, rating, release_date, poster_url, status) VALUES
('Singham Again', 'Rohit Shetty returns with another powerful entry in the Singham franchise. Ajay Devgn reprises his role as the fearless cop Bajirao Singham who takes on a new wave of crime and corruption. Packed with intense action, emotional depth, and a star-studded police universe, the film promises pure adrenaline.', 'Action', 'Hindi', 155, 8.3, '2025-03-07', 'https://upload.wikimedia.org/wikipedia/en/thumb/0/04/Singham_Again_poster.jpg/250px-Singham_Again_poster.jpg', 'now_showing'),
('Bhoot Police', 'Two brothers who run a fake ghost-hunting business get caught in a real supernatural encounter in the hills of Himachal. A horror-comedy starring Saif Ali Khan and Arjun Kapoor, the film mixes laughs and chills in equal measure.', 'Horror', 'Hindi', 128, 6.8, '2021-09-10', 'https://upload.wikimedia.org/wikipedia/en/4/4f/Bhoot_Police_film_poster.jpg', 'now_showing'),
('Housefull 5', 'The fifth installment in the Housefull franchise brings back familiar faces and fresh chaos. A madcap comedy of errors involving mistaken identities, lavish weddings, and wild adventures.', 'Comedy', 'Hindi', 150, 6.5, '2025-06-06', 'https://m.media-amazon.com/images/M/MV5BZmIzMThjNTYtNjkwZi00NmM3LTliNGItZWIxYTUwMGU1YzM0XkEyXkFqcGc@._V1_.jpg', 'now_showing'),
('War 2', 'Hrithik Roshan returns as Kabir in the high-octane sequel to War, teaming up with Jr NTR in a globe-trotting espionage thriller with international action sequences and intense drama.', 'Action', 'Hindi', 160, 8.1, '2025-08-14', 'https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/war-2-et00356501-1755672553.jpg', 'now_showing'),
('Adhura', 'Set in an elite boarding school, Adhura unravels a terrifying mystery surrounding a missing child and a series of haunting events. A psychological horror blending emotional trauma with dread.', 'Horror', 'Hindi', 124, 7.1, '2024-07-15', 'https://upload.wikimedia.org/wikipedia/en/thumb/0/02/Adhura_Poster.jpg/250px-Adhura_Poster.jpg', 'now_showing'),
('12th Fail', 'This inspiring drama tells the story of Manoj Sharma, who rose from poverty to become an IPS officer. It beautifully captures the spirit of perseverance, failure, and redemption.', 'Drama', 'Hindi', 147, 8.1, '2023-10-27', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToMxf_SsfLRqnKwc2ubQlH8Ii6Ede0cvhBTw&s', 'coming_soon'),
('Jawan', 'Shah Rukh Khan takes center stage in Atlee’s high-octane action thriller, portraying a vigilante with a mysterious past. Filled with social justice themes and massive action sequences.', 'Action', 'Hindi', 165, 7.2, '2023-09-07', 'https://resizing.flixster.com/lej1aNFjcromN2hYS5-638hSJ-k=/ems.cHJkLWVtcy1hc3NldHMvbW92aWVzL2FiOWE5MWYxLTc0MzctNGNjZi1hMjE0LWNhZmZiMDU2M2RhMS5qcGc=', 'now_showing'),
('Golmaal Again', 'The gang is back with even more laughter and ghostly mayhem in this horror-comedy ride featuring a haunted mansion and chaos-filled comedy.', 'Comedy', 'Hindi', 152, 8.5, '2021-08-15', 'https://upload.wikimedia.org/wikipedia/en/4/49/Ajay_Devgn%27s_Golmaal_Again_poster.jpg', 'now_showing'),
('Toxic', 'Yash and Nayanthara headline this intense gangster thriller exploring loyalty, betrayal, and brutal power struggles in the underworld.', 'Thriller', 'Hindi', 158, 7.2, '2025-04-10', 'https://m.media-amazon.com/images/M/MV5BMDZiNzAwZTQtYWIwMC00ODA0LWJiOGMtZTgzZGYzYzMxMDNiXkEyXkFqcGc@._V1_.jpg', 'now_showing'),
('Fateh', 'Sonu Sood’s directorial debut features him as an ex-intelligence officer dismantling a cyber mafia. A slick, action-packed film mixing technology with emotion.', 'Action', 'Hindi', 140, 7.2, '2025-01-10', 'https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/fateh-et00391731-1734092649.jpg', 'now_showing'),
('Kantara Chapter 1', 'A spiritual prequel to the acclaimed Kantara diving into divine justice and folklore with stunning visuals and mythological depth.', 'Thriller', 'Hindi', 155, 7.5, '2025-10-02', 'https://upload.wikimedia.org/wikipedia/en/thumb/6/69/Kantara-_Chapter_1_poster.jpg/250px-Kantara-_Chapter_1_poster.jpg', 'now_showing'),
('Raid 2', 'A direct continuation of the first film where an Income Tax officer exposes powerful figures, raising the stakes with deeper corruption and intensity.', 'Action', 'Hindi', 144, 7.8, '2025-05-01', 'https://stat4.bollywoodhungama.in/wp-content/uploads/2021/12/Raid2-1.jpg', 'coming_soon'),
('Pushpa 2: The Rule', 'Allu Arjun returns as Pushpa Raj in an explosive sequel continuing his rise in the red sandalwood underworld with intense storytelling and power-packed performances.', 'Thriller', 'Hindi', 170, 8.9, '2025-01-14', 'https://cdn.123telugu.com/content/wp-content/uploads/2024/10/Pushpa2-1.jpg', 'now_showing'),
('Sikandar', 'Salman Khan stars as a lone warrior caught between crime, politics, and revenge in this high-voltage entertainer.', 'Action', 'Hindi', 150, 7.3, '2025-04-01', 'https://upload.wikimedia.org/wikipedia/en/4/4a/Sikandar_2025_film_poster.jpg', 'now_showing'),
('Shaitaan', 'Ajay Devgn and R. Madhavan star in this gripping supernatural thriller where a family’s peaceful life turns dark after a stranger enters their home.', 'Horror', 'Hindi', 142, 7.4, '2024-03-08', 'https://m.media-amazon.com/images/M/MV5BOTdlZGE5YmUtZDE1Ny00NzUzLTg2YzYtNWYyMzgyNzRiY2EzXkEyXkFqcGc@._V1_.jpg', 'now_showing'),
('Chhori 2', 'The sequel to Chhori dives deeper into a cursed village’s horrifying secrets as the protagonist protects her unborn child from haunting forces.', 'Horror', 'Hindi', 138, 7.6, '2024-09-20', 'https://m.media-amazon.com/images/M/MV5BNTFhOTE4MWItZTdmZS00NTI0LTliM2ItNTM4ZjM5MjE0MTYxXkEyXkFqcGc@._V1_.jpg', 'now_showing'),
('Dragon', 'A fantasy-thriller set in a mythical kingdom featuring breathtaking visuals and intense battles in a story of courage and destiny.', 'Thriller', 'Hindi', 162, 7.9, '2025-02-21', 'https://resizing.flixster.com/idSqXXW1SHplGNnq6W67KnkK-_s=/ems.cHJkLWVtcy1hc3NldHMvbW92aWVzLzQyMWQ0OTJhLThkYjYtNDY0MS1hMDNhLTU4NDk3YWExMDllMy5qcGc=', 'now_showing'),
('Vash 2', 'A chilling continuation of the Shaitaan universe exploring dark magic, curses, and deep psychological horror.', 'Horror', 'Hindi', 140, 7.7, '2025-09-12', 'https://assets-in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/vash-level-2-et00430860-1755154833.jpg', 'now_showing'),
('OMG 2', 'A thought-provoking satirical comedy exploring sex education and societal hypocrisy with strong performances.', 'Comedy', 'Hindi', 150, 7.3, '2025-08-01', 'https://upload.wikimedia.org/wikipedia/en/thumb/5/56/OMG_2_%E2%80%93_Oh_My_God%21_2_poster.jpg/250px-OMG_2_%E2%80%93_Oh_My_God%21_2_poster.jpg', 'coming_soon'),
('Drishyam 2', 'Ajay Devgn returns as Vijay Salgaonkar in this gripping sequel where new evidence tests his intelligence and resolve once again.', 'Thriller', 'Hindi', 150, 7.8, '2025-07-19', 'https://filmik.blog/wp-content/uploads/2022/11/Drishyam-2-Movie-.webp', 'coming_soon');

-- =====================================================================================
   -- INSERT: THEATRES
-- =====================================================================================
INSERT INTO theatres (name, location, city, total_screens) VALUES
('PVR Cinemas',       'VR Mall',           'Surat', 5),
('INOX',              'Reliance Mall',     'Surat', 4),
('Cinepolis',         'Rahul Raj Mall',    'Surat', 6),
('CityPlus Multiplex','Valentine Mall',    'Surat', 3),
('Rajhans Cinemas',   'Adajan',            'Surat', 4),
('Carnival Cinemas',  'Vesu',              'Surat', 3),
('Broadway Cinema',   'Katargam',          'Surat', 2);

-- =====================================================================================
   -- INSERT: SCREENS
-- =====================================================================================
INSERT INTO screens (theatre_id, screen_name, total_seats) VALUES
-- PVR (ID: 1)
(1, 'Screen 1', 150),
(1, 'Screen 2', 180),
(1, 'Screen 3', 120),
(1, 'Screen 4', 200),
(1, 'Screen 5', 160),

-- INOX (ID: 2)
(2, 'Screen 1', 140),
(2, 'Screen 2', 160),
(2, 'Screen 3', 120),
(2, 'Screen 4', 150),

-- Cinepolis (ID: 3)
(3, 'Screen 1', 170),
(3, 'Screen 2', 190),
(3, 'Screen 3', 140),
(3, 'Screen 4', 160),
(3, 'Screen 5', 180),
(3, 'Screen 6', 150),

-- CityPlus (ID: 4)
(4, 'Screen 1', 130),
(4, 'Screen 2', 150),
(4, 'Screen 3', 140),

-- Rajhans (ID: 5)
(5, 'Screen 1', 175),
(5, 'Screen 2', 160),
(5, 'Screen 3', 140),
(5, 'Screen 4', 150),

-- Carnival (ID: 6)
(6, 'Screen 1', 110),
(6, 'Screen 2', 130),
(6, 'Screen 3', 120),

-- Broadway (ID: 7)
(7, 'Screen 1', 100),
(7, 'Screen 2', 120);

-- =====================================================================================
   -- INSERT: SHOWTIMES (CLEAN LAYOUT)
-- =====================================================================================
INSERT INTO showtimes (movie_id, screen_id, show_date, show_time) VALUES
-- Movie 1: Singham Again (PVR Screen 1)
(1, 1, CURDATE(), '10:00:00'),
(1, 1, CURDATE(), '14:00:00'),
(1, 1, CURDATE(), '18:00:00'),
(1, 1, CURDATE() + INTERVAL 1 DAY, '20:00:00'),

-- Movie 2: Bhoot Police (PVR Screen 2)
(2, 2, CURDATE(), '11:00:00'),
(2, 2, CURDATE(), '15:00:00'),
(2, 2, CURDATE(), '19:00:00'),
(2, 2, CURDATE() + INTERVAL 1 DAY, '21:00:00'),

-- Movie 3: Housefull 5 (PVR Screen 3)
(3, 3, CURDATE(), '10:30:00'),
(3, 3, CURDATE(), '14:30:00'),
(3, 3, CURDATE(), '18:30:00'),
(3, 3, CURDATE() + INTERVAL 1 DAY, '20:30:00'),

-- Movie 4: War 2 (PVR Screen 4)
(4, 4, CURDATE(), '09:45:00'),
(4, 4, CURDATE(), '13:45:00'),
(4, 4, CURDATE(), '17:45:00'),
(4, 4, CURDATE() + INTERVAL 1 DAY, '21:15:00'),

-- Movie 5: Adhura (PVR Screen 5)
(5, 5, CURDATE(), '12:00:00'),
(5, 5, CURDATE(), '16:00:00'),
(5, 5, CURDATE(), '20:00:00'),
(5, 5, CURDATE() + INTERVAL 1 DAY, '22:00:00'),

-- Movie 6: 12th Fail (INOX Screen 1)
(6, 6, CURDATE(), '10:15:00'),
(6, 6, CURDATE(), '13:15:00'),
(6, 6, CURDATE(), '16:15:00'),
(6, 6, CURDATE() + INTERVAL 1 DAY, '19:15:00'),

-- Movie 7: Jawan (INOX Screen 2)
(7, 7, CURDATE(), '09:30:00'),
(7, 7, CURDATE(), '13:30:00'),
(7, 7, CURDATE(), '17:30:00'),
(7, 7, CURDATE() + INTERVAL 1 DAY, '21:30:00'),

-- Movie 8: Golmaal Again (INOX Screen 3)
(8, 8, CURDATE(), '10:00:00'),
(8, 8, CURDATE(), '14:00:00'),
(8, 8, CURDATE(), '18:00:00'),
(8, 8, CURDATE() + INTERVAL 1 DAY, '22:00:00'),

-- Movie 9: Toxic (INOX Screen 4)
(9, 9, CURDATE(), '11:20:00'),
(9, 9, CURDATE(), '15:20:00'),
(9, 9, CURDATE(), '19:20:00'),
(9, 9, CURDATE() + INTERVAL 1 DAY, '21:20:00'),

-- Movie 10: Fateh (Cinepolis Screen 1)
(10, 10, CURDATE(), '10:10:00'),
(10, 10, CURDATE(), '13:10:00'),
(10, 10, CURDATE(), '16:10:00'),
(10, 10, CURDATE() + INTERVAL 1 DAY, '19:10:00'),

-- Movie 11: Kantara Chapter 1 (Cinepolis Screen 2)
(11, 11, CURDATE(), '10:50:00'),
(11, 11, CURDATE(), '14:50:00'),
(11, 11, CURDATE(), '18:50:00'),
(11, 11, CURDATE() + INTERVAL 1 DAY, '21:50:00'),

-- Movie 12: Raid 2 (Cinepolis Screen 3)
(12, 12, CURDATE(), '09:50:00'),
(12, 12, CURDATE(), '12:50:00'),
(12, 12, CURDATE(), '15:50:00'),
(12, 12, CURDATE() + INTERVAL 1 DAY, '18:50:00'),

-- Movie 13: Pushpa 2 (Cinepolis Screen 4)
(13, 13, CURDATE(), '10:25:00'),
(13, 13, CURDATE(), '14:25:00'),
(13, 13, CURDATE(), '18:25:00'),
(13, 13, CURDATE() + INTERVAL 1 DAY, '21:25:00'),

-- Movie 14: Sikandar (Cinepolis Screen 5)
(14, 14, CURDATE(), '11:00:00'),
(14, 14, CURDATE(), '15:00:00'),
(14, 14, CURDATE(), '19:00:00'),
(14, 14, CURDATE() + INTERVAL 1 DAY, '22:00:00'),

-- Movie 15: Shaitaan (Cinepolis Screen 6)
(15, 15, CURDATE(), '12:10:00'),
(15, 15, CURDATE(), '15:10:00'),
(15, 15, CURDATE(), '18:10:00'),
(15, 15, CURDATE() + INTERVAL 1 DAY, '21:10:00'),

-- Movie 16: Chhori 2 (CityPlus Screen 1)
(16, 16, CURDATE(), '09:55:00'),
(16, 16, CURDATE(), '12:55:00'),
(16, 16, CURDATE(), '15:55:00'),
(16, 16, CURDATE() + INTERVAL 1 DAY, '18:55:00'),

-- Movie 17: Dragon (CityPlus Screen 2)
(17, 17, CURDATE(), '11:15:00'),
(17, 17, CURDATE(), '14:15:00'),
(17, 17, CURDATE(), '17:15:00'),
(17, 17, CURDATE() + INTERVAL 1 DAY, '20:15:00'),

-- Movie 18: Vash 2 (CityPlus Screen 3)
(18, 18, CURDATE(), '10:40:00'),
(18, 18, CURDATE(), '13:40:00'),
(18, 18, CURDATE(), '16:40:00'),
(18, 18, CURDATE() + INTERVAL 1 DAY, '19:40:00'),

-- Movie 19: OMG 2 (Rajhans Screen 1)
(19, 19, CURDATE(), '11:30:00'),
(19, 19, CURDATE(), '14:30:00'),
(19, 19, CURDATE(), '17:30:00'),
(19, 19, CURDATE() + INTERVAL 1 DAY, '20:30:00'),

-- Movie 20: Drishyam 2 (Rajhans Screen 2)
(20, 20, CURDATE(), '10:20:00'),
(20, 20, CURDATE(), '13:20:00'),
(20, 20, CURDATE(), '16:20:00'),
(20, 20, CURDATE() + INTERVAL 1 DAY, '19:20:00');
