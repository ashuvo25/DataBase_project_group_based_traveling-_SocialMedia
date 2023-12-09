<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Budget List</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #4267B2;
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    main {
      max-width: 800px;
      margin: 20px auto;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }

    form {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    label {
      margin-bottom: 8px;
      display: block;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    button {
      background-color: #4267B2;
      color: #fff;
      padding: 10px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #eee;
    }
  </style>
</head>
<body>
  <header>
    <h1>Budget List</h1>
  </header>

  <main>
    <form id="userBudgetForm">
      <label for="userFrom">From:</label>
      <input type="text" id="userFrom" placeholder="Enter 'From'" required>

      <label for="userTo">To:</label>
      <input type="text" id="userTo" placeholder="Enter 'To'" required>

      <label for="userTransport">Transport:</label>
      <input type="text" id="userTransport" placeholder="Enter 'Transport'" required>

      <label for="userFare">Fare:</label>
      <input type="number" id="userFare" placeholder="Enter 'Fare'" required>

      <button type="button" onclick="addItem('user')">Add Item</button>
    </form>

    <form id="anotherBudgetForm">
      <label for="anotherFrom">From:</label>
      <input type="text" id="anotherFrom" placeholder="Enter 'From'" required>

      <label for="anotherTo">To:</label>
      <input type="text" id="anotherTo" placeholder="Enter 'To'" required>

      <label for="anotherTransport">Transport:</label>
      <input type="text" id="anotherTransport" placeholder="Enter 'Transport'" required>

      <label for="anotherFare">Fare:</label>
      <input type="number" id="anotherFare" placeholder="Enter 'Fare'" required>

      <button type="button" onclick="addItem('another')">Add Item</button>
    </form>

    <ul id="userBudgetList"></ul>
    <ul id="anotherBudgetList"></ul>
  </main>

  <script>
    function addItem(user) {
      const from = document.getElementById(`${user}From`).value;
      const to = document.getElementById(`${user}To`).value;
      const transport = document.getElementById(`${user}Transport`).value;
      const fare = document.getElementById(`${user}Fare`).value;

      if (from && to && transport && fare) {
        const budgetList = document.getElementById(`${user}BudgetList`);
        const listItem = document.createElement('li');
        listItem.innerHTML = `<span>From: ${from}</span><span>To: ${to}</span><span>Transport: ${transport}</span><span>Fare: $${fare}</span>`;
        budgetList.appendChild(listItem);

        // Clear input fields
        document.getElementById(`${user}From`).value = '';
        document.getElementById(`${user}To`).value = '';
        document.getElementById(`${user}Transport`).value = '';
        document.getElementById(`${user}Fare`).value = '';
      } else {
        alert('Please fill in all fields.');
      }
    }
  </script>
</body>
</html>
