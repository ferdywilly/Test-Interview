<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
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
    <h1>Update Book</h1>
    <form id="updateBookForm">
        <label for="title">Title:</label>
        <input type="text" id="title" value="" required>

        <label for="author">Author:</label>
        <input type="text" id="author" value="" required>

        <label for="category">category:</label>
        <input type="text" id="category" value="" required>

        <button type="submit">Update Book</button>
    </form>

    <script>
        const bookId = "{{ $id }}"
         axios.get(`/api/books/${bookId}`)
            .then(response => {
                const book = response.data.data;
                document.getElementById('title').value = book.title;
                document.getElementById('author').value = book.author;
                document.getElementById('category').value = book.category_id;
            })
            .catch(error => {
                console.error(error);
                alert("Error fetching book data");
            });

        document.getElementById('updateBookForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const title = document.getElementById('title').value;
            const author = document.getElementById('author').value;
            const category_id = document.getElementById('category').value;

            axios.put(`/api/books/${bookId}`, { title, author, category_id })
                .then(response => {
                    alert(response.data.message);
                    window.location.href = '/';
                })
                .catch(error => {
                    console.error(error);
                    alert("Error updating book");
                });
        });
    </script>
</body>
</html>
