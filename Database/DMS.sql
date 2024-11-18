-- Table structure for `hall`
CREATE TABLE `hall` (
  `ID` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`ID`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `floor`
CREATE TABLE `floor` (
  `Floor_Number` varchar(10) NOT NULL,
  `ID_hall` int(11) NOT NULL,
  `Num_of_Room` int(5) NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`Floor_Number`, `ID_hall`),
  FOREIGN KEY (`ID_hall`) REFERENCES `hall`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for `login`
CREATE TABLE `login` (
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `room`
CREATE TABLE `room` (
  `ID` int(10) NOT NULL,
  `Name_Room` varchar(20) NOT NULL,
  `ID_floor` int(10) NOT NULL,
  `Num_of_Bed` int(5) NOT NULL,
  `Rent_fee` float(10) NOT NULL,
  `Gender` boolean NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`ID`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for `student`
CREATE TABLE `student` (
  `ID` int(8) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `DOB` date NOT NULL,
  `Phone_number` VARCHAR(10) NOT NULL,
  `Email` VARCHAR(100) NOT NULL,
  `ID_Room` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ID_Room`) REFERENCES `room`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for `rent_fee`
CREATE TABLE `rent_fee` (
  `ID` int(5) NOT NULL,
  `ID_student` int(8) NOT NULL,
  `Content` varchar(30) NOT NULL,
  `Fee` float(5) NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ID_student`) REFERENCES `student`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for `facility_problem`
CREATE TABLE `facility_problem` (
  `ID` int(5) NOT NULL,
  `ID_student` int(8) NOT NULL,
  `Content` varchar(100) NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ID_student`) REFERENCES `student`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for `message_table`
CREATE TABLE `message_table` (
  `ID` int(5) NOT NULL,
  `ID_student` int(20) DEFAULT NULL,
  `Name` varchar(20) NOT NULL,
  `Room_Num` varchar(20) DEFAULT NULL,
  `Messages` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ID_student`) REFERENCES `student`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `login` (`username`, `password`) VALUES
('admin', 'admin');
