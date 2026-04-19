<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Currency Converter</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }

        .container {
            width: 350px;
            margin: 50px auto;
            background: #ccc;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        input, select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            width: 95%;
            padding: 10px;
            background: #2d8cf0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1a73e8;
        }

        .result {
            margin-top: 15px;
            background: black;
            color: white;
            padding: 15px;
            min-height: 50px;
        }

        .rates {
            margin-top: 15px;
            font-size: 12px;
            color: #555;
        }
    </style>

</head>
<body>

<div class="container">
    <h2>Currency Converter</h2>

    <label>Amount</label>
    <input type="number" id="amount" placeholder="Enter amount" min="0">

    <label>From</label>
    <select id="fromCurrency">
        <option value="FRW">FRW - Rwandan Franc</option>
        <option value="USD">USD - US Dollar</option>
        <option value="EUR">EUR - Euro</option>
    </select>

    <label>To</label>
    <select id="toCurrency">
        <option value="FRW">FRW - Rwandan Franc</option>
        <option value="USD">USD - US Dollar</option>
        <option value="EUR">EUR - Euro</option>
    </select>

    <button onclick="convertCurrency()">CONVERT</button>

    <div class="result" id="result">Result Here...</div>

    <div class="rates">
        <p><strong>Exchange Rates (approx):</strong></p>
        <p>1 USD = 1,450 FRW</p>
        <p>1 EUR = 1,680 FRW</p>
        <p>1 USD ≈ 0.86 EUR</p>
    </div>
</div>

<script>
    const rates = {
        FRW: 1,
        USD: 1450,
        EUR: 1680
    };

    function convertCurrency() {
        let amount = parseFloat(document.getElementById("amount").value);
        let from = document.getElementById("fromCurrency").value;
        let to = document.getElementById("toCurrency").value;
        let resultBox = document.getElementById("result");

        if (isNaN(amount) || amount < 0) {
            resultBox.innerHTML = "Please enter a valid amount!";
            return;
        }

        let result;

        if (from === to) {
            result = amount;
        } else if (from === "FRW") {
            result = amount / rates[to];
        } else if (to === "FRW") {
            result = amount * rates[from];
        } else {
            result = (amount * rates[from]) / rates[to];
        }

        let formattedResult = result.toFixed(2);
        resultBox.innerHTML = amount + " " + from + " = " + formattedResult + " " + to;
    }
</script>

</body>
</html>