<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Sales Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-lg mx-auto my-5 bg-white rounded-lg p-5 shadow-md">

    <h2 class="text-center text-2xl font-bold mb-4">
        Daily Sales Report
    </h2>

    <p class="text-gray-700 mb-4">
        The following products are ordered today:
    </p>

    <table class="w-full border-collapse mt-2">
        <thead>
        <tr class="bg-gray-100 border-b border-gray-200">
            <th class="px-3 py-2 text-left">Product Name</th>
            <th class="px-3 py-2 text-left">Quantity Ordered</th>
            <th class="px-3 py-2 text-left">Product Price</th>
            <th class="px-3 py-2 text-left">Total Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dailySales as $product)
            <tr class="border-b border-gray-200">
                <td class="px-3 py-2">{{ $product->name }}</td>
                <td class="px-3 py-2">{{ $product->quantity }}</td>
                <td class="px-3 py-2">{{ $product->price }} {{ $product->currency }}</td>
                <td class="px-3 py-2">{{ $product->totalprice }} {{ $product->currency }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="text-gray-500 text-sm mt-4 text-center">
        This is an automated notification from your store. Please do not reply.
    </p>

</div>

</body>
</html>
