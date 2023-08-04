document.getElementById("emailForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    // Convert form data to JSON
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    // Send the JSON data to the backend using AJAX
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                document.getElementById("emailResult").innerHTML = response.email;
            } else {
                document.getElementById("emailResult").innerHTML = "Error generating email.";
            }
        }
    };
    xhr.open("POST", "generate_email.php");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify(jsonData));
});
