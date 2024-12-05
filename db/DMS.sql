-- Table structure for `hall`
CREATE TABLE `hall` (
  `H_ID` int NOT NULL AUTO_INCREMENT,
  `H_Name` varchar(250) NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`H_ID`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `floor`
CREATE TABLE `floor` (
  `F_ID` int NOT NULL AUTO_INCREMENT,
  `Floor_Number` varchar(10) NOT NULL,
  `H_ID` int NOT NULL,
  `Num_of_Room` int NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`F_ID`),
  FOREIGN KEY (`H_ID`) REFERENCES `hall`(`H_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

-- Table structure for `login`
CREATE TABLE `login` (
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `room`
CREATE TABLE `room` (
  `R_ID` int NOT NULL AUTO_INCREMENT,
  `R_Name` varchar(20) NOT NULL,
  `F_ID` int NOT NULL,
  `Num_of_Table` int NOT NULL,
  `Num_of_Bed` int NOT NULL,
  `Gender` boolean NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`R_ID`), 
  FOREIGN KEY (`F_ID`) REFERENCES `floor`(`F_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `student`
CREATE TABLE `Student` (
  `Stu_id` int NOT NULL,
  `Name` varchar(40) NOT NULL,
  `DOB` date NOT NULL,
  `Phone_number` VARCHAR(10) NOT NULL,
  `Email` VARCHAR(100) NOT NULL,
  `Gender` boolean NOT NULL,
  `R_ID` int NOT NULL,
  PRIMARY KEY (`Stu_id`),
  FOREIGN KEY (`R_ID`) REFERENCES `room`(`R_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `rent_fee`
CREATE TABLE `rent_fee` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `R_ID` int NOT NULL,
  `Period` varchar(30) NOT NULL,
  `Room_Bill` float NOT NULL,
  `Elec_Bill` float NOT NULL,
  `Internet_Bill` float NOT NULL,
  `Water_Bill` float NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`R_ID`) REFERENCES `room`(`R_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `facility_problem`
CREATE TABLE `facility_problem` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `R_ID` int NOT NULL,
  `Content` varchar(100) NOT NULL,
  `Status` boolean NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`R_ID`) REFERENCES `room`(`R_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for `message_table`
CREATE TABLE `message_table` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_student` int(20) DEFAULT NULL,
  `Name` varchar(20) NOT NULL,
  `R_Name` varchar(20) DEFAULT NULL,
  `Messages` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ID_student`) REFERENCES `student`(`Stu_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `login` (`username`, `password`) VALUES
('admin', 'admin'),
('lam@example.com', '12345678'),
('duc@example.com', '12345678'),
('kyanh@example.com', '12345678'),
('my@example.com', '12345678');


INSERT INTO `hall` (`H_ID`, `H_Name`, `Status`) VALUES
(NULL, 'B5', 1),
(NULL, 'B6', 1),
(NULL, 'B7', 1),
(NULL, 'B8', 1),
(NULL, 'B9', 1);



INSERT INTO `floor` (`Floor_Number`, `H_ID`, `Num_of_Room`, `Status`) VALUES
('B5/F1', 1, 10, 1),
('B5/F2', 1, 10, 1),
('B5/F3', 1, 10, 1),
('B5/F4', 1, 10, 1),
('B6/F1', 2, 10, 1),
('B6/F2', 2, 10, 1),
('B6/F3', 2, 10, 1),
('B6/F4', 2, 10, 1),
('B7/F1', 3, 10, 1),
('B7/F2', 3, 10, 1),
('B7/F3', 3, 10, 1),
('B7/F4', 3, 10, 1),
('B8/F1', 4, 10, 1),
('B8/F2', 4, 10, 1),
('B8/F3', 4, 10, 1),
('B8/F4', 4, 10, 1),
('B9/F1', 5, 10, 1),
('B9/F2', 5, 10, 1),
('B9/F3', 5, 10, 1),
('B9/F4', 5, 10, 1);




INSERT INTO `room` (`R_Name`, `F_ID`, `Num_of_Table`, `Num_of_Bed`, `Gender`, `Status`) VALUES
('B5F101', 1, 2, 4, 1, 1), ('B5F102', 1, 1, 3, 0, 0), ('B5F103', 1, 2, 2, 1, 1), ('B5F104', 1, 1, 3, 0, 1), 
('B5F105', 1, 3, 4, 1, 1), ('B5F106', 1, 2, 3, 0, 0), ('B5F107', 1, 1, 2, 1, 1), ('B5F108', 1, 2, 3, 0, 1), 
('B5F109', 1, 3, 4, 1, 1), ('B5F110', 1, 1, 3, 0, 0),
('B5F201', 2, 2, 4, 1, 1), ('B5F202', 2, 1, 2, 0, 1), ('B5F203', 2, 3, 4, 1, 0), ('B5F204', 2, 2, 3, 0, 1), 
('B5F205', 2, 1, 3, 1, 1), ('B5F206', 2, 3, 4, 0, 0), ('B5F207', 2, 2, 2, 1, 1), ('B5F208', 2, 1, 3, 0, 1), 
('B5F209', 2, 2, 4, 1, 0), ('B5F210', 2, 1, 2, 0, 1),
('B5F301', 3, 3, 4, 1, 1), ('B5F302', 3, 1, 2, 0, 0), ('B5F303', 3, 2, 3, 1, 1), ('B5F304', 3, 1, 3, 0, 1), 
('B5F305', 3, 2, 4, 1, 0), ('B5F306', 3, 1, 2, 0, 1), ('B5F307', 3, 3, 4, 1, 1), ('B5F308', 3, 2, 3, 0, 0), 
('B5F309', 3, 1, 2, 1, 1), ('B5F310', 3, 2, 3, 0, 1),
('B5F401', 4, 2, 4, 1, 1), ('B5F402', 4, 1, 3, 0, 0), ('B5F403', 4, 3, 4, 1, 1), ('B5F404', 4, 2, 3, 0, 1), 
('B5F405', 4, 1, 2, 1, 0), ('B5F406', 4, 2, 4, 0, 1), ('B5F407', 4, 3, 3, 1, 1), ('B5F408', 4, 1, 2, 0, 0), 
('B5F409', 4, 2, 4, 1, 1), ('B5F410', 4, 1, 3, 0, 1),

('B6F101', 5, 3, 4, 1, 1), ('B6F102', 5, 2, 3, 0, 1), ('B6F103', 5, 1, 2, 1, 0), ('B6F104', 5, 3, 4, 0, 1), 
('B6F105', 5, 2, 3, 1, 1), ('B6F106', 5, 1, 2, 0, 0), ('B6F107', 5, 3, 4, 1, 1), ('B6F108', 5, 2, 3, 0, 1), 
('B6F109', 5, 1, 3, 1, 1), ('B6F110', 5, 2, 4, 0, 0),
('B6F201', 6, 3, 4, 1, 1), ('B6F202', 6, 2, 3, 0, 1), ('B6F203', 6, 1, 2, 1, 0), ('B6F204', 6, 3, 4, 0, 1),
('B6F205', 6, 2, 3, 1, 1), ('B6F206', 6, 1, 2, 0, 0), ('B6F207', 6, 3, 4, 1, 1), ('B6F208', 6, 2, 3, 0, 1),
('B6F209', 6, 1, 3, 1, 1), ('B6F210', 6, 2, 4, 0, 0),

('B7F101', 9, 1, 3, 1, 1), ('B7F102', 9, 2, 4, 0, 1), ('B7F103', 9, 3, 2, 1, 0), ('B7F104', 9, 1, 3, 0, 1), 
('B7F105', 9, 2, 4, 1, 1), ('B7F106', 9, 3, 3, 0, 0), ('B7F107', 9, 1, 2, 1, 1), ('B7F108', 9, 2, 4, 0, 1), 
('B7F109', 9, 3, 3, 1, 1), ('B7F110', 9, 1, 2, 0, 0),
('B7F201', 10, 2, 3, 1, 1), ('B7F202', 10, 3, 4, 0, 1), ('B7F203', 10, 1, 2, 1, 0), ('B7F204', 10, 2, 4, 0, 1), 
('B7F205', 10, 3, 3, 1, 1), ('B7F206', 10, 1, 2, 0, 0), ('B7F207', 10, 2, 4, 1, 1), ('B7F208', 10, 3, 3, 0, 1), 
('B7F209', 10, 1, 2, 1, 1), ('B7F210', 10, 2, 4, 0, 0),
('B7F301', 11, 3, 3, 1, 1), ('B7F302', 11, 1, 2, 0, 1), ('B7F303', 11, 2, 4, 1, 0), ('B7F304', 11, 3, 3, 0, 1), 
('B7F305', 11, 1, 2, 1, 1), ('B7F306', 11, 2, 4, 0, 0), ('B7F307', 11, 3, 3, 1, 1), ('B7F308', 11, 1, 2, 0, 1), 
('B7F309', 11, 2, 4, 1, 0), ('B7F310', 11, 3, 3, 0, 1),
('B7F401', 12, 1, 2, 1, 1), ('B7F402', 12, 2, 4, 0, 1), ('B7F403', 12, 3, 3, 1, 0), ('B7F404', 12, 1, 2, 0, 1), 
('B7F405', 12, 2, 4, 1, 1), ('B7F406', 12, 3, 3, 0, 0), ('B7F407', 12, 1, 2, 1, 1), ('B7F408', 12, 2, 4, 0, 1), 
('B7F409', 12, 3, 3, 1, 1), ('B7F410', 12, 1, 2, 0, 0),

('B8F101', 13, 2, 3, 1, 1), ('B8F102', 13, 3, 4, 0, 1), ('B8F103', 13, 1, 2, 1, 0), ('B8F104', 13, 2, 3, 0, 1), 
('B8F105', 13, 3, 4, 1, 1), ('B8F106', 13, 1, 2, 0, 0), ('B8F107', 13, 2, 3, 1, 1), ('B8F108', 13, 3, 4, 0, 1), 
('B8F109', 13, 1, 3, 1, 1), ('B8F110', 13, 2, 4, 0, 0),
('B8F201', 14, 3, 3, 1, 1), ('B8F202', 14, 1, 2, 0, 1), ('B8F203', 14, 2, 4, 1, 0), ('B8F204', 14, 3, 3, 0, 1), 
('B8F205', 14, 1, 2, 1, 1), ('B8F206', 14, 2, 4, 0, 0), ('B8F207', 14, 3, 3, 1, 1), ('B8F208', 14, 1, 2, 0, 1), 
('B8F209', 14, 2, 4, 1, 0), ('B8F210', 14, 3, 3, 0, 1),
('B8F301', 15, 2, 4, 1, 1), ('B8F302', 15, 3, 3, 0, 1), ('B8F303', 15, 1, 2, 1, 0), ('B8F304', 15, 2, 3, 0, 1), 
('B8F305', 15, 3, 4, 1, 1), ('B8F306', 15, 1, 2, 0, 0), ('B8F307', 15, 2, 3, 1, 1), ('B8F308', 15, 3, 4, 0, 1), 
('B8F309', 15, 1, 3, 1, 1), ('B8F310', 15, 2, 4, 0, 0),
('B8F401', 16, 3, 4, 1, 1), ('B8F402', 16, 1, 3, 0, 1), ('B8F403', 16, 2, 4, 1, 0), ('B8F404', 16, 3, 3, 0, 1), 
('B8F405', 16, 1, 2, 1, 1), ('B8F406', 16, 2, 3, 0, 0), ('B8F407', 16, 3, 4, 1, 1), ('B8F408', 16, 1, 3, 0, 1), 
('B8F409', 16, 2, 4, 1, 0), ('B8F410', 16, 3, 3, 0, 1),

('B9F101', 17, 2, 4, 1, 1), ('B9F102', 17, 1, 3, 0, 1), ('B9F103', 17, 3, 4, 1, 0), ('B9F104', 17, 2, 3, 0, 1), 
('B9F105', 17, 2, 4, 1, 0), ('B9F106', 17, 1, 3, 1, 1), ('B9F107', 17, 3, 4, 0, 1), ('B9F108', 17, 2, 3, 1, 0), 
('B9F109', 17, 1, 4, 0, 1), ('B9F110', 17, 2, 3, 1, 1), 

('B9F201', 18, 3, 4, 0, 1), ('B9F202', 18, 2, 3, 1, 0), ('B9F203', 18, 1, 3, 1, 1), ('B9F204', 18, 3, 4, 0, 1), 
('B9F205', 18, 2, 3, 0, 1), ('B9F206', 18, 1, 4, 1, 0), ('B9F207', 18, 3, 4, 1, 1), ('B9F208', 18, 2, 3, 0, 1), 
('B9F209', 18, 1, 3, 1, 0), ('B9F210', 18, 2, 4, 1, 1),

('B9F301', 19, 1, 3, 0, 1), ('B9F302', 19, 2, 4, 1, 1), ('B9F303', 19, 3, 4, 0, 0), ('B9F304', 19, 2, 3, 0, 1), 
('B9F305', 19, 1, 4, 1, 1), ('B9F306', 19, 3, 3, 1, 0), ('B9F307', 19, 2, 4, 0, 1), ('B9F308', 19, 1, 3, 1, 0), 
('B9F309', 19, 2, 4, 0, 1), ('B9F310', 19, 1, 3, 1, 1), 

('B9F401', 20, 3, 4, 1, 0), ('B9F402', 20, 2, 3, 0, 1), ('B9F403', 20, 1, 3, 1, 1), ('B9F404', 20, 2, 4, 0, 0), 
('B9F405', 20, 3, 4, 1, 1), ('B9F406', 20, 1, 4, 0, 1), ('B9F407', 20, 2, 3, 1, 0), ('B9F408', 20, 3, 4, 0, 1), 
('B9F409', 20, 1, 3, 0, 1), ('B9F410', 20, 2, 4, 1, 0);


INSERT INTO `student` (`Stu_id`, `Name`, `DOB`, `Phone_number`, `Email`, `Gender`, `R_ID`) VALUES
(20198237, 'Thái Văn Lâm', '2000-01-01', '0123456789', 'lam@example.com', 1, 1),
(20207592, 'Nguyễn Minh Đức', '2000-05-15', '0987654321', 'duc@example.com', 1, 2),
(20207586, 'Lê Kỳ Anh', '2001-03-22', '0912345678', 'kyanh@example.com', 1, 3),
(20207644, 'Hoàng Hà My', '2001-07-10', '0978123456', 'my@example.com', 1, 4);



INSERT INTO `rent_fee` (`R_ID`, `Period`, `Room_Bill`, `Elec_Bill`, `Internet_Bill`, `Water_Bill`, `Status`)
SELECT 
  r.R_ID, 
  '2024-11', 
  CASE 
    WHEN r.Status = 1 THEN 2000000 
    ELSE 0 
  END AS Room_Bill,
  CASE 
    WHEN r.Status = 1 THEN 150000 
    ELSE 0 
  END AS Elec_Bill,
  CASE 
    WHEN r.Status = 1 THEN 100000 
    ELSE 0 
  END AS Internet_Bill,
  CASE 
    WHEN r.Status = 1 THEN 50000 
    ELSE 0 
  END AS Water_Bill,
  r.Status
FROM 
  `room` r
WHERE 
  r.Status = 1;




INSERT INTO `facility_problem` (`R_ID`, `Content`, `Status`) VALUES
(1, 'Điều hòa hỏng', 0),
(2, 'Đèn phòng không sáng', 0),
(3, 'Cửa sổ bị vỡ', 1),
(4, 'Máy giặt bị hư', 0),
(5, 'Cần bảo trì tivi', 1),
(6, 'Hỏng khóa cửa', 0),
(7, 'Hệ thống điện bị mất', 1),
(8, 'Điều hòa cần bảo dưỡng', 0),
(9, 'Bể nước bị rò rỉ', 1),
(10, 'Mất điện trong phòng', 0),
(11, 'Bình nóng lạnh hỏng', 1),
(12, 'Quạt không chạy', 0),
(13, 'Mất nước nóng', 1),
(14, 'Cửa sổ bị hỏng khóa', 0),
(15, 'Máy lọc nước hư', 1),
(16, 'Bể bơi hỏng', 0),
(17, 'Sàn nhà bị thấm nước', 1),
(18, 'Cần sửa bồn rửa', 0),
(19, 'Thang máy không hoạt động', 1),
(20, 'Cửa phòng bị kẹt', 0);


INSERT INTO `message_table` (`ID_student`, `Name`, `R_Name`, `Messages`) VALUES
(20198237, 'Thái Văn Lâm', 'B5F101', 'Xin cấp giấy xác nhận ở KTX'),
(20207592, 'Nguyễn Minh Đức', 'B5F102', 'Phòng B5F202 làm ồn sau 0h đêm'),
(20207586, 'Lê Kỳ Anh', 'B5F103', 'Xin cấp thẻ gửi xe máy tháng 12'),
(20207644, 'Hoàng Hà My', 'B5F104', 'Cơm nhà hàng A không đảm bảo'),
(20198237, 'Thái Văn Lâm', 'B5F101', 'Xin đổi phòng sang KTX B9');


