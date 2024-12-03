<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quản lý vấn đề CSVC</title>
	<link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
		integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

	<style>
		body {
			display: flex;
			font-family: 'Roboto', sans-serif;
			margin: 0;
			background-color: #f9f9f9;
		}

		.slidebar {
			width: 20%;
			height: 100%;
			position: fixed;
			background-color: #2c3e50;
			padding-top: 20px;
			top: 0;
			left: 0;
			z-index: 100;
		}

		.slidebar header {
			padding: 30px 10px;
			text-align: center;
			font-size: 30px;
			font-weight: bolder;
			color: #ecf0f1;
		}

		.slidebar header span {
			font-size: 50px;
			color: #1abc9c;
		}

		.slidebar ul {
			padding: 0;
			list-style: none;
			margin: 0;
		}

		.slidebar ul li {
			padding: 10px;
			font-size: 18px;
			font-weight: bolder;
			color: #ecf0f1;
			margin-bottom: 10px;
		}

		.slidebar ul li:hover {
			transform: scale(1.05);
			transition: 0.3s;
			background-color: #1abc9c;
			margin-right: 20px;
			border-radius: 10px;
		}

		.slidebar ul li a {
			text-decoration: none;
			color: inherit;
		}

		.slidebar ul li.active {
			background-color: #1abc9c;
			color: white;
			border-radius: 10px;
		}

		.slidebar ul li.active a {
			color: white;
			text-decoration: none;
		}

		main {
			margin-left: 20%;
			padding: 20px;
			flex-grow: 1;
		}

		.button-container {
			display: flex;
			justify-content: center;
			gap: 20px;
			margin-bottom: 20px;
		}

		.button {
			background-color: #4CAF50;
			border: none;
			color: white;
			padding: 10px 25px;
			text-align: center;
			border-radius: 5px;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			font-size: 16px;
			transition: all 0.3s ease;
		}

		.button:hover {
			background-color: #45a049;
		}

		.button i {
			margin-right: 8px;
		}

		.button a {
			text-decoration: none;
			color: white;
			display: block;
			text-align: center;
		}

		.tdr {
			text-align: center;
		}

		#delete,
		#update {
			border-radius: 9px;
		}

		#link1 {
			color: black;
			text-decoration: none;
			font-size: 15px;
		}

		table {
			width: 90%;
			max-width: 1020px;
			margin: 20px auto;
			border-collapse: collapse;
		}

		th,
		td {
			padding: 8px 12px;
			text-align: center;
			font-size: 14px;
			border: 1px solid #ddd;
			word-wrap: break-word;
		}

		th {
			background-color: #f4f4f4;
			font-weight: bold;
		}

		td {
			background-color: #fff;
			max-width: 150px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.pagination {
			text-align: center;
			margin: 20px 0;
		}

		.pagination a {
			margin: 0 5px;
			padding: 8px 12px;
			border: 1px solid #ddd;
			color: #007bff;
			border-radius: 5px;
			text-decoration: none;
		}

		.pagination a.active {
			background-color: #007bff;
			color: white;
		}

		.pagination span {
			margin: 0 5px;
		}

		.logout-container {
			position: absolute;
			bottom: 70px;
			left: 50%;
			transform: translateX(-50%);
			width: 100%;
			text-align: center;
		}

		/* Logout Button */
		.logout {
			font-family: 'Roboto', sans-serif;
			font-weight: 700;
			font-size: 16px;
			color: #fff;
			background-color: #8e44ad;
			padding: 15px 30px;
			border-radius: 30px;
			transition: all 0.3s ease;
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
			display: inline-block;
		}

		/* Hover effect */
		.logout:hover {
			transform: scale(1.1);
			color: #fff;
			background-color: #9b59b6;
			box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
		}

		/* Active effect */
		.logout:active {
			transform: scale(1.05);
		}
	</style>
</head>

<body>
	<!-- Sidebar -->
	<div class="slidebar">
		<header>
			<span><i class="fas fa-users-cog"></i></span>
			ADMIN
		</header>
		<ul>
			<li><a href="../Hall/DispHall.php"><i class="fas fa-building"></i> Tòa nhà</a></li>
			<li><a href="../Rent_fee/DispRentFee.php"><i class="fas fa-wallet"></i> Chi phí</a></li>
			<li><a href="../Student/DispStudent.php"><i class="fas fa-book-reader"></i> Sinh viên</a></li>
			<li><a href="../Floor/DispFloor.php"><i class="fas fa-layer-group"></i> Tầng</a></li>
			<li><a href="../Room/DispRoom.php"><i class="fa fa-bed"></i> Phòng</a></li>
			<li class="active"><a href="../FacilitiesProblem/DispFP.php"><i class="fas fa-exclamation-triangle"></i> Vấn đề về cơ sở vật chất</a></li>
			<li><a href=""><i class="fas fa-envelope-open"></i> Messages</a></li>
		</ul>
		<div class="logout-container">
			<a style="text-decoration: none;" href="../index.php">
				<div class="logout">Đăng xuất</div>
			</a>
		</div>
	</div>

	<!-- Main content -->
	<main>
		<center>
			<div class="button-container" style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-bottom: 20px;">
				<button class="button">
					<a href="Insert.php">
						<i class="fas fa-plus"></i> Thêm
					</a>
				</button>
				<button class="button">
					<a href="../dashboard/home.php">
						<i class="fas fa-home"></i> Trang chủ
					</a>
				</button>
				<form method="GET" action="" style="display: flex; align-items: center; gap: 10px;">
					<input type="text" name="search" placeholder="Nhập tên phòng..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="padding: 8px; font-size: 16px; width: 250px; border-radius: 5px; border: 1px solid #ddd;">
					<button type="submit" class="button" style="padding: 8px 16px; font-size: 16px;">Tìm kiếm</button>
				</form>
			</div>
		</center>

		<table align="center" border="1px" style="width:1100px; line-height:40px;">
			<tr>
				<th colspan="7">
					<h2>Quản lý vấn đề Cơ sở vật chất</h2>
				</th>
			</tr>
			<tr>
				<th>Tên phòng</th>
				<th>Tầng</th>
				<th>Tòa nhà</th>
				<th>Nội dung</th>
				<th>Trạng thái</th>
				<th>Hành động</th>
			</tr>
			<?php
			include '../CommonMethods/connection.php';

			$search = isset($_GET['search']) ? $_GET['search'] : '';

			$limit = 10;
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$offset = ($page - 1) * $limit;

			$count_sql = "SELECT COUNT(*) AS total FROM facility_problem fp, room r WHERE fp.R_ID = r.R_ID AND R_Name LIKE '%$search%'";
			$count_result = mysqli_query($conn, $count_sql);
			$count_row = mysqli_fetch_assoc($count_result);
			$total_fp = $count_row['total'];
			$total_pages = ceil($total_fp / $limit);

			$sql = "SELECT ID, R_Name, Floor_Number, H_Name, Content,
                 CASE 
                    WHEN fp.Status = 1 THEN 'Đã xử lý' 
                    WHEN fp.Status = 0 THEN 'Chưa xử lý' 
                    ELSE 'Không xác định' 
                 END AS fpStatus
        FROM room r
        INNER JOIN floor f ON r.F_ID = f.F_ID
        INNER JOIN hall h ON f.H_ID = h.H_ID
		INNER JOIN facility_problem fp ON fp.R_ID = r.R_ID 
        WHERE R_Name LIKE '%$search%'  
        ORDER BY fpStatus, R_Name
        LIMIT $limit OFFSET $offset";

			$query = mysqli_query($conn, $sql);

			while ($row1 = mysqli_fetch_array($query)) {
			?>
				<tr>
					<td class="tdr"><?php echo $row1['R_Name']; ?></td>
					<td class="tdr"><?php echo $row1['Floor_Number']; ?></td>
					<td class="tdr"><?php echo $row1['H_Name']; ?></td>
					<td class="tdr"><?php echo $row1['Content']; ?></td>
					<td class="tdr"><?php echo $row1['fpStatus']; ?></td>
					<td style="width: 140px;">
						<button id="delete">
							<a href="Delete.php?ID=<?php echo $row1['ID']; ?>" id="link1" onclick="return confirmDelete()">
								<i class="fas fa-trash"></i> Xóa
							</a>
						</button>
						<button id="update">
							<a href="Update.php?ID=<?php echo $row1['ID']; ?>" id="link1">
								<i class="fas fa-edit"></i> Sửa
							</a>
						</button>
					</td>
				</tr>
			<?php
			}
			?>
		</table>

		<div class="pagination">
			<?php
			if ($total_pages > 1) {
				if ($page > 2) {
					echo "<a href='?page=1&search=$search'>1</a>";
					if ($page > 3) {
						echo "<span>...</span>";
					}
				}
				for ($i = max(1, $page - 1); $i <= min($total_pages, $page + 1); $i++) {
					if ($i == $page) {
						echo "<a class='active'>$i</a>";
					} else {
						echo "<a href='?page=$i&search=$search'>$i</a>";
					}
				}
				if ($page < $total_pages - 1) {
					echo "<span>...</span>";
					echo "<a href='?page=$total_pages&search=$search'>$total_pages</a>";
				}
			}
			?>
		</div>
	</main>
</body>
<script>
	function confirmDelete() {
		var confirmation = confirm("Bạn có chắc chắn muốn xóa không?");
		if (confirmation) {
			return true;
		} else {
			return false;
		}
	}
</script>

</html>