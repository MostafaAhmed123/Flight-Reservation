var data = new Map();

function continueSignUp() {
    var form = document.getElementById("registrationForm");

    if (form.elements["email"].value !== "" && form.elements["name"].value !== "" && form.elements["password"].value !== "") {

        var type = document.getElementById("passenger");
        document.getElementById("tobehidden").style.display = "none";
        if (type.checked) {

            document.getElementById("passengerform").style.display = "block";
        } else {
            document.getElementById("companyform").style.display = "block";
        }

        document.getElementById("submit-btn").style.display = "block";
    } else {
        alert("Please fill out all required fields.");
    }
}


function back(){
    document.getElementById("passengerform").style.display = "none";
    document.getElementById("companyform").style.display = "none";
    document.getElementById("submit-btn").style.display = "none";
    document.getElementById("tobehidden").style.display = "block";
}
