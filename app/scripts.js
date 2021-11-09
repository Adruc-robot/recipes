$(document).ready(function() {
    var modal = document.getElementById('myModal');
    $(".recipe").click(function() {
        var modTit = document.getElementById("recNam");
        var tName = this.getAttribute('data-name');
        modTit.innerHTML = tName;
        var modStps = document.getElementById("recSteps");        
        modStps.innerHTML = "<p>Steps:</p>" + this.getAttribute("data-steps");
        var modIng = document.getElementById("recIngs");
        modIng.innerHTML = "    <p>Ingredients:</p>" + this.getAttribute('data-ingredients');
        //modal.style.display = "block"; 
        modal.style.display = "grid";
    }); 
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        //console.log("poop");
        $(".recipe").filter(function() {
            if (($(this).data('ingredients').toLowerCase().indexOf(value) == -1) && ($(this).text().toLowerCase().indexOf(value) == -1) ) {
                $(this).hide();
            } else {
                $(this).show();
            };
        });
    });
});