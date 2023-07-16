
<table>
        <thead>
          <tr>
            

         
        </thead>
         </tr>
</table>



<tbody>
    <?php      
           $conn = mysqli_connect("localhost", "root", "", "database");
           $sql = "SELECT * FROM requests_slot";
           $result = $conn->query($sql);
           if ($result->num_rows > 0) {
            # code...
            while($row= $result-> fetch_assoc()){
                ?>
                
          <tr>
          <td><?php echo $row['type'] ?></td>
            <td><?php echo $row['username'] ?></td>
            <td><?php echo $row['address'] ?></td>
            <td><?php echo $row['number'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['selectedSlots'] ?></td>
            <td><?php echo $row['num_Slots'] ?></td>
            <td><?php echo $row['date'] ?></td>
            <td><?php echo $row['duration'] . ($row['duration'] > 1 ? " months" : "month") ?></td>
            <td>₱<?php echo number_format($row['payment'], 0) ?></td>   
            <?php $row['end_date'] ?>
                     
            <td>
            <a href="" title="View Payment" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter<?= $row['id'] ?>"><i class="fas fa-eye"></i></a>
            <a href="accept_RFSlot.php?id=<?php echo $row['id'] ?>&type=<?php echo $row['type'] ?>&username=<?php echo $row['username'] ?>&address=<?php echo $row['address'] ?>&number=<?php echo $row['number'] ?>&email=<?php echo $row['email'] ?>&selectedSlots=<?php echo $row['selectedSlots'] ?>&num_Slots=<?php echo $row['num_Slots'] ?>&date=<?php echo $row['date'] ?>&duration=<?php echo $row['duration'] ?>&payment=<?php echo $row['payment'] ?>&end_date=<?php echo $row['end_date']?>" title="Accept" class="btn btn-success"><i class="fas fa-check"></i></a>
            <a href="delete_RFSlot.php?id=<?php echo $row['id']?>&email=<?php echo $row['email']?>&type=<?php echo $row['type']?>" title="Decline" class="btn btn-danger"><i class="fas fa-trash"></i></a>

            </td>
          </tr>

            </tbody>
            <?php
              }
          }
      ?>