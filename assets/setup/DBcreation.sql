
--
-- Database: `loginsystem`
--

create schema klik_loginsystem;
use klik_loginsystem;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full-name` varchar(255) DEFAULT NULL,
  `last-name` varchar(255) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile-image` varchar(255) DEFAULT NULL,
  `banner-image` varchar(255) DEFAULT NULL,
  `user-level` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;
