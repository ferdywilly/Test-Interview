<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Create Category</h1>
    <form id="createCategoryForm">
        <label for="name">Name:</label>
        <input type="text" id="name" value="" required>
        <button type="submit">Create Category</button>
    </form>

    <script>
        document.getElementById('createCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('name').value;

            axios.post('/api/categories', { name })
                .then(response => {
                    alert(response.data.message);
                    window.location.href = '/'; 
                })
                .catch(error => {
                    console.error(error);
                    alert("Error creating category");
                });
        });
    </script>
</body>
</html>
