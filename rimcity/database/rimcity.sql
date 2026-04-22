-- ============================================================
-- RimCity — database schema + seed data
-- 10CTE Task 1 — Internet and Website Development
--
-- Import this file in phpMyAdmin (or via the command line) to
-- create the `rimcity` database, both tables, and all 20 products.
--
-- Column names, types and sizes match the task spec exactly.
-- ============================================================

CREATE DATABASE IF NOT EXISTS `rimcity`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `rimcity`;

-- Drop in reverse-dependency order so reruns are idempotent
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `Category`;

-- ----------------------------------------
-- Category table
-- ----------------------------------------
CREATE TABLE `Category` (
  `CategoryId`   INT AUTO_INCREMENT PRIMARY KEY,
  `CategoryName` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------
-- Product table
-- ----------------------------------------
CREATE TABLE `Product` (
  `ProductId`          INT AUTO_INCREMENT PRIMARY KEY,
  `ProductName`        VARCHAR(100)  NOT NULL,
  `ProductDescription` LONGTEXT      NOT NULL,
  `ImageFile`          VARCHAR(50)   NOT NULL,
  `Price`              DECIMAL(6,2)  NOT NULL,
  `CategoryId`         INT           NOT NULL,
  CONSTRAINT `fk_Product_Category`
    FOREIGN KEY (`CategoryId`) REFERENCES `Category`(`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------------------
-- Seed data
-- ----------------------------------------
INSERT INTO `Category` (`CategoryId`, `CategoryName`) VALUES
  (1, 'Sneakers'),
  (2, 'Jerseys'),
  (3, 'Balls'),
  (4, 'Accessories');

INSERT INTO `Product`
  (`ProductName`, `ProductDescription`, `ImageFile`, `Price`, `CategoryId`)
VALUES
-- === Sneakers ===
('RimCity Apex 1',
 'The flagship Apex 1 pairs an engineered knit upper with full-length AirCore responsive foam and a herringbone rubber outsole for grip in every direction. A carbon-fibre midfoot plate keeps torsion locked down on explosive first steps. Built for quick guards and combo wings who need to cut hard and recover faster. When the game has to be won in the first three seconds, this is the shoe.',
 'apex1.jpg', 220.00, 1),

('RimCity Glide Pro',
 'A low-profile silhouette with a woven upper, internal lacing cage for midfoot lockdown, and AirCore Lite foam that keeps the shoe under 340g per foot. Designed for smooth-operating playmakers who live off changes of pace. The segmented rubber outsole adds flex grooves for natural forefoot roll. Wear them on the floor — or straight off the plane.',
 'glide_pro.jpg', 180.00, 1),

('RimCity Court King',
 'Premium tumbled leather overlays wrap a padded hi-top collar, delivering the ankle lockdown post players demand. A dual-density midsole cushions landings in the paint while a wide outsole footprint stops roll-overs. Purpose-built for bigs and physical forwards who play below the rim. Classic looks, modern feel.',
 'court_king.jpg', 195.00, 1),

('RimCity Dunker 2',
 'Our most explosive silhouette — a Bounce PU foam sole returns energy on every takeoff, while the cross-strap over the laces locks your foot to the board. A reinforced rubber toe cap handles drag-step finishes. Made for leapers, finishers and anyone whose game starts above the rim. Pair with courage.',
 'dunker_2.jpg', 160.00, 1),

('RimCity Street Low',
 'A streetball-first low-top built in durable suede and canvas with a thick gum-rubber outsole for outdoor courts. The cushy sockliner keeps long runs on concrete comfortable. Styled to double as a casual shoe off the court. Scuff-resistant, weather-tested, city-approved.',
 'street_low.jpg', 140.00, 1),

-- === Jerseys ===
('RimCity Home Jersey',
 'The official home kit in lightweight DriMesh polyester with a tailored athletic fit and flatlock side seams that lay flat under pads and sleeves. Moisture-wicking panels run up the spine to pull sweat off your skin in hot halls. Screen-printed front crest and twill back numbers. Made for rec-league and rep players alike.',
 'home_jersey.jpg', 85.00, 2),

('RimCity Away Jersey',
 'Same engineered DriMesh fabric and tailored cut as the Home kit, finished in a deep charcoal body with orange trim and contrast piping. A dropped back hem keeps the tail tucked through full-speed transitions. Lightweight, breathable, and built to move. For players who do not care which end of the floor they defend.',
 'away_jersey.jpg', 85.00, 2),

('RimCity Throwback 95',
 'A heavyweight mesh tribute to the baggy 90s cut — longer body, wider armholes, and double-stitched numbers on twill panels that age in all the right ways. Embroidered chest badge adds a premium finish. Built for streetball stylists, history nerds and anyone who thinks modern jerseys are too fitted. Wears in beautifully.',
 'throwback_95.jpg', 110.00, 2),

('RimCity Training Singlet',
 'A featherweight training top in pinhole-mesh poly with flat-lock seams to stop chafing on long sessions. Cut for full shoulder mobility on shooting drills and conditioning work. Dries in minutes between reps. A summer-camp essential for players grinding through twin training blocks.',
 'training_singlet.jpg', 55.00, 2),

('RimCity Warm-Up Tee',
 'A soft cotton-polyester blend tee with a relaxed fit — easy to pull off right before tip-off. A printed RimCity wordmark across the chest keeps the team look consistent on the bench. Pre-shrunk so it stays true to size wash after wash. For warm-ups, cool-downs and the drive home.',
 'warmup_tee.jpg', 45.00, 2),

-- === Balls ===
('RimCity Pro Game Ball',
 'Full-grain tanned leather with a deep pebbled surface and moisture-channeling grip, broken in at the factory so it is game-ready out of the box. Official size 7, nylon-wound for a true bounce. Built for indoor league play on timber courts. The ball you bring when the game counts.',
 'pro_game_ball.jpg', 95.00, 3),

('RimCity Indoor Elite',
 'A premium composite leather ball with deep channels for guaranteed grip through long sessions. Butyl bladder holds air longer than lower-grade competitors. Official size 7 and a soft touch straight off the shelf. Ideal for high-school and club training where budgets still care about feel.',
 'indoor_elite.jpg', 80.00, 3),

('RimCity Street Outdoor',
 'A rugged rubber composite built to survive concrete, bitumen and rooftop courts without losing its grip. Deep channels and a tacky pebbled surface keep handles sharp in the sun or rain. Official size 7. For the player whose court does not have a roof.',
 'street_outdoor.jpg', 45.00, 3),

('RimCity Training Ball',
 'A weighted training ball, 200g heavier than a standard size 7, engineered to build forearm and wrist strength through reps. Switch back to your game ball and watch your release snap. Rubber outer survives outdoor work. Used by development coaches across Australia\'s junior rep system.',
 'training_ball.jpg', 40.00, 3),

('RimCity Junior Size 5',
 'A properly-sized junior ball (size 5, 27.5") for players aged roughly 8 to 11, so technique develops without bad habits from oversized adult balls. Soft composite cover is easy on young hands. Bright RimCity graphics keep it easy to spot in a gym full of balls. A great first serious ball.',
 'junior_size5.jpg', 35.00, 3),

-- === Accessories ===
('RimCity Arm Sleeve',
 'A compression nylon-spandex shooting sleeve with anti-slip silicone bands at the bicep so it stays put through full-speed sprints. UPF 50 rating for outdoor play under summer sun. Worn for muscle support, warmth on cold benches, or just because it looks good. Sold as a single, one size fits most teens and adults.',
 'arm_sleeve.jpg', 25.00, 4),

('RimCity Headband 2-Pack',
 'Classic terry-cotton headbands in a two-pack — one orange, one charcoal — with a wide elastic band that holds a stretched fit through the longest session. Fast-drying and machine-washable. Absorbs sweat so it does not end up in your eyes on the biggest possession of the night. A team-bag essential.',
 'headband_2pack.jpg', 20.00, 4),

('RimCity Elite Socks',
 'Crew-length performance socks with cushioned heel and toe zones, arch compression, and mesh venting over the instep. A reinforced achilles pad stops shoe-rub on hard cuts. Moisture-wicking fibres keep your feet dry through back-to-back games. For players who refuse to blame their socks.',
 'elite_socks.jpg', 30.00, 4),

('RimCity Court Backpack',
 'A 25-litre tough-poly backpack with a dedicated ball pocket, a padded 15" laptop sleeve, and a separate vented shoe compartment underneath. Ergonomic shoulder straps distribute load for the walk from car park to court. Built for student athletes who go school to training to home without stopping. Cleans up easily after a wet training.',
 'court_backpack.jpg', 70.00, 4),

('RimCity Ball Pump Kit',
 'A dual-action hand pump with an inline pressure gauge, three metal needles, and a flexible hose for tight ball pockets. Inflates a size 7 ball in under 15 strokes. Fits in any training bag and stops you ever being the team-mate who "forgot the pump". The kit every coach wishes every player owned.',
 'ball_pump_kit.jpg', 18.00, 4);
