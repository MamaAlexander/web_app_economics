<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Input</title>
</head>
<body>
    <form onsubmit="return validateInput()">
        <label for="numberInput">Enter a number:</label>
        <input type="number" id="numberInput" name="numberInput" min="0" max="100" required>
        <input type="submit" value="Submit">
    </form>

    <script>
        function validateInput() {
            const input = document.getElementById('numberInput').value;
            if (isNaN(input) || input === '') {
                alert('Please enter a valid number.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
