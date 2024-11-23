<!DOCTYPE html>
<html>

<head>

  <title> Quản lý phòng </title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url(../images/images.jpg);
      background-size: cover;
      background-repeat: no-repeat;
      font-family: 'Roboto', sans-serif;
    }

    .tdr {
      text-align: center;
    }

    button-container {
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

    #delete {
      border-radius: 9px 9px;

    }

    #link1 {
      color: black;
      text-decoration: none;
      font-size: 15px;
    }

    #update {
      border-radius: 9px 9px;

    }
  </style>
</head>

<body>

  <center>
    <div class="button-container">
      <button class="button">
        <a href="Room.html">
          <i class="fas fa-plus"></i> Thêm phòng
        </a>
      </button>
      <button class="button">
        <a href="index.html">
          <i class="fas fa-search"></i> Tìm kiếm
        </a>
      </button>
      <button class="button">
        <a href="../dashboard/home.php">
          <i class="fas fa-home"></i> Trang chủ
        </a>
      </button>
    </div>
  </center>
  <table align="center" border="1px" style="width:1100px; line-height:40px;">
    <tr>
      <th colspan="8">
        <h2>Quản lý phòng</h2>
      </th>
    </tr>
    <th> ID phòng </th>
    <th> Tên phòng </th>
    <th> Tầng </th>
    <th> Tòa nhà </th>
    <th> Số lượng bàn </th>
    <th> Số lượng giường </th>
    <th> Giới tính</th>
    <th> Hành động </th>

    </tr>
    <?php
    include 'connection.php';
    $limit = 20;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    $count_sql = "SELECT COUNT(*) AS total FROM room";
    $count_result = mysqli_query($conn, $count_sql);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rooms = $count_row['total'];
    $total_pages = ceil($total_rooms / $limit);

    $sql = "SELECT R_ID, R_Name, Floor_Number, H_Name, Num_of_Table, Num_of_Bed, 
               CASE 
                   WHEN Gender = 1 THEN 'Nam' 
                   WHEN Gender = 0 THEN 'Nữ' 
                   ELSE 'Không xác định' 
               END AS Gender
        FROM room r
        INNER JOIN floor f ON r.F_ID = f.F_ID
        INNER JOIN hall h ON f.H_ID = h.H_ID
        ORDER BY R_Name
        LIMIT $limit OFFSET $offset";
    $query = mysqli_query($conn, $sql);
    while ($row1 = mysqli_fetch_array($query)) {
    ?>
      <a href=""></a>
      <tr>
        <td class="tdr"><?php echo $row1['R_ID']; ?></td>
        <td class="tdr"><?php echo $row1['R_Name']; ?></td>
        <td class="tdr"><?php echo $row1['Floor_Number']; ?></td>
        <td class="tdr"><?php echo $row1['H_Name']; ?></td>
        <td class="tdr"><?php echo $row1['Num_of_Table']; ?></td>
        <td class="tdr"><?php echo $row1['Num_of_Bed']; ?></td>
        <td class="tdr"><?php echo $row1['Gender']; ?></td>
        <td style="width: 140px;">
          <button id="delete">
            <a href="Delete.php?R_ID=<?php echo $row1['R_ID']; ?>" id="link1" onclick="return confirmDelete()">
              <i class="fas fa-trash"></i> Xóa
            </a>
          </button>
          <button id="update">
            <a href="Update.php?R_ID=<?php echo $row1['R_ID']; ?>" id="link1">
              <i class="fas fa-edit"></i> Sửa
            </a>
          </button>

        </td>
      </tr>
    <?php
    }
    ?>
  </table>

  <div class="pagination" style="text-align: center; margin-top: 20px;">
    <?php
    $adjacents = 2;

    if ($total_pages > 1) {
      if ($page > 3) {
        echo "<a style='margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; color: #007bff; border-radius: 5px; text-decoration: none;' href='?page=1'>1</a>";
      }

      if ($page > ($adjacents + 2)) {
        echo "<span style='margin: 0 5px;'>...</span>";
      }
      for ($i = max(1, $page - $adjacents); $i <= min($total_pages, $page + $adjacents); $i++) {
        if ($i == $page) {
          echo "<a style='margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; background-color: #007bff; color: white; border-radius: 5px; text-decoration: none;'>$i</a>";
        } else {
          echo "<a style='margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; color: #007bff; border-radius: 5px; text-decoration: none;' href='?page=$i'>$i</a>";
        }
      }
      if ($page < ($total_pages - $adjacents - 1)) {
        echo "<span style='margin: 0 5px;'>...</span>";
      }
      if ($page + 2 < $total_pages) {
        echo "<a style='margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; color: #007bff; border-radius: 5px; text-decoration: none;' href='?page=$total_pages'>$total_pages</a>";
      }
    }
    ?>
  </div>

</body>

<script>
  function confirmDelete() {
    var confirmation = confirm("Bạn có chắc chắn muốn xóa phòng này không?");
    if (confirmation) {
      return true;
    } else {
      return false;
    }
  }
</script>

</html>