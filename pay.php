<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة رصيد</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 1rem;
        }
        input {
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            margin-top: 1rem;
            padding: 0.5rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #message {
            margin-top: 1rem;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>إضافة رصيد</h1>
        <form id="addBalanceForm">
            <label for="amount">المبلغ:</label>
            <input type="number" id="amount" name="amount" required min="0" step="0.01">
            
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">إضافة الرصيد</button>
        </form>
        <div id="message"></div>
    </div>

    <script>
        document.getElementById('addBalanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const amount = document.getElementById('amount').value;
            const password = document.getElementById('password').value;
            
            if (amount <= 0) {
                alert('يرجى إدخال مبلغ صحيح');
                return;
            }
            
            fetch('add_balance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `amount=${amount}&password=${password}`
            }).then(console.log("wqd"))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').textContent = data.message;
                    document.getElementById('addBalanceForm').reset();
                } else {
                    alert(data.message);
                }
                console.log(data.success)
            })
            // .catch(error => {
            //     console.error('Error:', error);
            //     alert('حدث خطأ أثناء إضافة الرصيد');
            // });
        });
    </script>
</body>
</html>