<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books and Categories</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Daftar Buku dan Kategori</h1>

    <h2>Daftar Buku</h2>
    <button onclick="window.location.href='/books/create'">Buat Buku</button>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Borrowed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="books-body"></tbody>
    </table>

    <h2>Daftar Kategori</h2>
    <button onclick="window.location.href='/category/create'">Buat category</button>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="categories-body"></tbody>
    </table>

    <h2>Daftar Buku Dipinjam</h2>
    <table>
      <thead>
          <tr>
              <th>No</th>
              <th>Title</th>
              <th>Author</th>
              <th>Category</th>
              <th>Borrowed</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody id="borrowed-body"></tbody>
  </table>

    <script>
        axios.get('/api/books')
            .then(response => {
              console.log(response)
                const booksBody = document.getElementById('books-body');
                let number = 1;
                response.data.data.forEach(book => {
                    const row = `<tr>
                        <td>${number++}</td>
                        <td>${book.title}</td>
                        <td>${book.author}</td>
                        <td>${book.category.name}</td>
                        <td>${book.is_borrowed ? 'Yes' : 'No'}</td>
                        <td>
                            <button onclick="editBook(${book.id})">Update</button>
                            <button onclick="deleteBook(${book.id})">Delete</button>
                            ${book.is_borrowed ? '' : `<button onclick="borrowBook(${book.id})">Borrow</button>`}
                        </td>
                    </tr>`;
                    booksBody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('/api/categories')
            .then(response => {
                const categoriesBody = document.getElementById('categories-body');
                let number = 1;
                response.data.data.forEach(category => {
                    const row = `<tr>
                        <td>${number++}</td>
                        <td>${category.name}</td>
                        <td>
                          <button onclick="editCategory(${category.id})">Update</button>
                          <button onclick="deleteCategory(${category.id})">Delete</button>
                        </td>
                    </tr>`;
                    categoriesBody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error(error);
            });

            axios.get('/api/borrowed-books')
            .then(response => {
                const borrowedBody = document.getElementById('borrowed-body');
                console.log(response)
                let number = 1;
                response.data.data.forEach(book => {
                    const row = `<tr>
                        <td>${number++}</td>
                        <td>${book.title}</td>
                        <td>${book.author}</td>
                        <td>${book.category.name}</td>
                        <td>${book.is_borrowed ? 'Yes' : 'No'}</td>
                        <td>
                            ${book.is_borrowed ? `<button onclick="returnBook(${book.id})">Return</button>` : ''}
                        </td>
                    </tr>`;
                    borrowedBody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error(error);
            });

            function deleteBook(id) {
              axios.delete(`/api/books/${id}`)
                  .then(response => {
                      alert(response.data.message);
                      location.reload();
                  })
                  .catch(error => {
                      console.error(error);
                      alert("Error deleting book");
                  });
              }

            function borrowBook(id) {
              axios.post(`/api/books/${id}/borrow`)
                  .then(response => {
                      alert(response.data.message);
                      location.reload();
                  })
                  .catch(error => {
                      console.error(error);
                      alert("Error borrow book");
                  });
              }

            function returnBook(id) {
              axios.post(`/api/books/${id}/return`)
                  .then(response => {
                      alert(response.data.message);
                      location.reload();
                  })
                  .catch(error => {
                      console.error(error);
                      alert("Error return book");
                  });
              }

              function deleteCategory(id) {
              axios.delete(`/api/categories/${id}`)
                  .then(response => {
                      alert(response.data.message);
                      location.reload();
                  })
                  .catch(error => {
                      console.error(error);
                      alert("Error deleting category");
                  });
              }

            function editBook(id) {
              window.location.href = `/books/${id}/edit`;
            }

            function editCategory(id) {
              window.location.href = `/categories/${id}/edit`;
            }

    </script>
</body>
</html>
