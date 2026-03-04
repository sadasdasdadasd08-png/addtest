<!DOCTYPE html>
<html>
<head>
    <title>Add Lead</title>
</head>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #007BFF; }
        nav a:hover { text-decoration: underline; }
        h2 { margin-top: 20px; }
        form { margin-top: 20px; max-width: 400px; }
        input { display: block; width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #007BFF; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        pre { background-color: #f2f2f2; padding: 10px; overflow-x: auto; }
        .form-b{max-width:320px;margin:auto;text-align:center;}
    </style>
<body>

<nav>
    <a href="index.php">Add Lead</a> |
    <a href="statuses.php">Lead Statuses</a>
</nav>



<div class='form-b'>
    <h2>Add Lead</h2>
    <form method="POST" action="addlead.php">
    <input type="text" name="firstName" placeholder="First Name" required><br>
    <input type="text" name="lastName" placeholder="Last Name" required><br>
    <input type="tel" name="phone" placeholder="Phone" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <button type="submit">Submit</button>
</form>
</div>

</body>
</html>