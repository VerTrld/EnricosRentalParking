var count = 0;
var total = 0;
var price = Number(document.getElementById("priceInput").value);
var click = document.getElementById("layout");
var countDisplay = document.getElementById("count");
var totalDisplay = document.getElementById("total");
var priceInput = document.getElementById("priceInput");

// Update total display when seats are clicked or price is updated
click.addEventListener("click", function() {
  var selected = document.querySelectorAll("#layout .selected");
  count = selected.length;
  countDisplay.innerHTML = count;
  updateTotalDisplay();
});

priceInput.addEventListener("input", function() {
  if (priceInput.value) {
    price = Number(priceInput.value);
    localStorage.setItem("price", price);
    updateTotalDisplay();
  }
});

function updateTotalDisplay() {
  total = count * price;
  totalDisplay.innerHTML = total.toLocaleString();
}

// Initialize the price display
updateTotalDisplay();


 const selectedSeats = new Set();
  const displaySelectedSeats = () => {
    const selectedSeatsDiv = document.querySelector('#selected-seats');
    selectedSeatsDiv.textContent = `Selected slots: ${Array.from(selectedSeats).join(', ')}`;
  };
  const toggleSeatSelection = (seatDiv) => {
    if (seatDiv.classList.contains("processed")) {
      return;
    }
    const seatId = seatDiv.dataset.id;
    if (selectedSeats.has(seatId)) {
      selectedSeats.delete(seatId);
    } else {
      selectedSeats.add(seatId);
    }
    displaySelectedSeats();
  };
  
  const seatDivs = document.querySelectorAll('.seat:not(.taken)');
  seatDivs.forEach((seatDiv) => {
    seatDiv.addEventListener('click', () => {
      toggleSeatSelection(seatDiv);
    });
  });

 function myBtn(){

 if(selectedSeats.size > 0){

 const selectedSeatsArray = Array.from(selectedSeats);
 const selectedSeatsString = selectedSeatsArray.join(',');
 var xhr = new XMLHttpRequest();
 xhr.open('POST', 'save.php');
 xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
 xhr.onload = function() {
     // Handle the server's response
     if (this.readyState == 4 && this.status == 200) {
   
         console.log(xhr.responseText);
       

     } else {
         console.log('Error saving total to database.');
     }
 };
 window.location.href = 'register.php?count=' + count + '&total=' + total + '&selectedSeats=' + selectedSeatsString;

 }
}
