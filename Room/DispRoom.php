<!DOCTYPE html>
<html>

<head>

  <title> Quản lý phòng </title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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

    .button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 10px 25px;
      text-align: center;
      margin-top: 60px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }

    #delete {
      background-color: #f44336;
      color: black;
      border-radius: 9px 9px;

    }

    #link1 {
      color: black;
      text-decoration: none;
      font-size: 15px;
    }

    #update {
      background-color: blue;
      color: black;
      border-radius: 9px 9px;
    }
  </style>
</head>

<body>
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
          <button id="delete"><a href="Delete.php?Room_Number=<?php echo $row1["R_ID"]; ?>"
              id="link1">Delete</a></button>
          <button id="update"><a href="Update.php?Room_Number=<?php echo $row1["R_ID"]; ?>"
              id="link1">Update</a></button>

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
      if ($page > 1) {
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
      if ($page < $total_pages) {
        echo "<a style='margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; color: #007bff; border-radius: 5px; text-decoration: none;' href='?page=$total_pages'>$total_pages</a>";
      }
    }
    ?>
  </div>
  <center>
    <button class="button"> <a href="Room.html" style="text-decoration: none;">INSERT</a> </button>
    <button class="button"> <a href="index.html" style="text-decoration: none;">Search</a> </button>
    <button class="button"> <a href="../dashboard/home.php" style="text-decoration: none;">Home Page</a> </button>
  </center>
</body>

</html>