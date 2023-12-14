var data = new Map();
function containueSignUp(){
    var form = document.getElementById("registrationForm");
    if(form.elements["email"].value != "" && form.elements["name"].value != 0 && form.elements["password"].value != ""){
            for(let i = 0; i < form.elements.length; i++){
            if(form.elements[i].validity.valid)
            {if(form.elements[i].name != "type")
                data.set(form.elements[i].name, form.elements[i].value);
            console.log(data.get(form.elements[i].name));}
            else{
                alert("Make sure to enter valid inputs");
                return;
            }
        }
        if(document.getElementById("passenger").checked)
            data.set("type", "passenger")
        else
        data.set("type", "company")
        form.style.display = "none";
        if(data.get("type") == "passenger"){
            document.getElementById("passengerform").style.display = "block";
        }
        else{
            document.getElementById("companyform").style.display = "block";
        }
    }
    else
        alert("Please fill out all required fields.");
}

function signUp(){
    if(data.get("type") == "passenger"){
        var passportInput = document.getElementById("passportImg");
        if(passportInput.files.length > 0){
            for(let i = 0; i < passportInput.files.length; i++){
                data.set(passportInput.files[i].name, passportInput.files[i].value);
            }
        }
        else{
            alert("Please fill out all required fields.");
        }
    }
    else{
        var form = document.getElementById("companyform");
        var logo = document.getElementById("logo");
        if(form.elements["bio"] != "" && form.elements["address"] != "" && form.elements["username"] != "" && logo.files[0]){
            for(let i = 0; i < form.elements.length; i++){
                var element = form.elements[i];
                if(element.type != "file")
                {
                    if(element.validity.valid)
                        data.set(element.name, element.value);
                    else{
                        alert("Make sure to enter valid inputs");
                        return;
                    }
                }
            }
            data.set("logo", logo.files[0]);
        }
        else
            alert("Please fill out all required fields.")
    }
    var formData = new FormData();
    for (var pair of data.entries())
        formData.append(pair[0], pair[1]);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './backend/signup.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        console.log('Success:', response.message);
                    } else {
                        console.error('Error:', response.message);
                    }
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };

        xhr.onerror = function () {
            console.error('Network error occurred.');
        };
        xhr.send(formData);
}