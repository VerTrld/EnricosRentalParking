<table>
        <thead>
          <tr>
            

         
        </thead>
         </tr>
</table>



<tbody>

<tbody>
       <?php
          
           $conn = mysqli_connect("localhost", "root", "", "database");
           $sql = "SELECT * FROM requests";
           $result = $conn->query($sql);
           if ($result->num_rows > 0) {
            # code...
            while($row= $result-> fetch_assoc()){
                ?>
        <tbody>
        <tr>
            <td><?php echo $row['username'] ?></td>
            <td><?php echo $row['address'] ?></td>
            <td><?php echo $row['number'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['selectedSlots'] ?></td>
            <td><?php echo $row['num_Slots'] ?></td>
            <td><?php echo $row['date'] ?></td>
            <td><?php echo $row['duration'] . ($row['duration'] > 1 ? " months" : "month") ?></td>
            <td>₱<?php echo number_format($row['payment'], 0) ?></td>         
            <td>
            <a href="view_modal.php?id=<?php echo $row['id'] ?>" title="View" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-eye"></i></a>
              <a href="accept.php?id=<?php echo $row['id'] ?>" title="Accept" class="btn btn-success"><i class="fas fa-check"></i></a>
              <a href="delete.php?id=<?php echo $row['id']?>&email=<?php echo $row['email']?>" title="Decline" class="btn btn-danger"><i class="fas fa-trash"></i></a>
            </td>
          </tr>

          </tbody>
          <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $images = explode(" ", $row['images']);
                    foreach ($images as $image) {
                        if (!empty($image)) {
                          echo '<a href="../upload/' . $image . '"><img src="../upload/' . $image . '" width="100px"></a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal -->

          <?php
              }
          }
      ?>