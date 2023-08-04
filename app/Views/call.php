<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test call</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>
<body>
    <a href="#" id="myLink">Test call login</a>
    <br /><br />
    <div id="resultDiv"></div>
    <script>
    function handleLinkClick() {

        const postData = {
            username: 'mariorossi',
            password: '12345678'
        };

        fetch('http://localhost/php/apiMvc/products/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(postData)
        })   
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('resultDiv');
            resultDiv.innerText = JSON.stringify(data);
        })
        .catch(error => {
            console.error('Error call:', error);
            const resultDiv = document.getElementById('resultDiv');
            resultDiv.innerText = 'Error call.' + error;
        });
    }

    const myLink = document.getElementById('myLink');
    myLink.addEventListener('click', handleLinkClick);
</script>


</body>
</html>