<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Sales Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Create Sales Order</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('sales-orders.store') }}" method="POST" id="sales-order-form">
        @csrf

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Product</th>
                <th>Available</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th><button type="button" class="btn btn-sm btn-primary" id="add-row">Add</button></th>
            </tr>
            </thead>
            <tbody id="order-items">
            <tr>
                <td>
                    <select name="products[0][id]" class="form-select product-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->quantity }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="stock">-</td>
                <td class="price" data-value="0">-</td>
                <td>
                    <input type="number" name="products[0][quantity]" class="form-control quantity" min="1" value="1" required>
                </td>
                <td class="subtotal">-</td>
                <td><button type="button" class="btn btn-sm btn-danger remove-row">X</button></td>
            </tr>
            </tbody>
        </table>

        <div class="text-end">
            <strong>Total: ₹<span id="total-amount">0.00</span></strong>
        </div>

        <button type="submit" class="btn btn-success mt-3">Confirm Order</button>
    </form>
</div>

<script>
    let rowIdx = 1;

    function recalculateTotal() {
        let total = 0;
        document.querySelectorAll('#order-items tr').forEach(row => {
            const price = parseFloat(row.querySelector('.price').dataset.value || 0);
            const qty = parseInt(row.querySelector('.quantity').value || 0);
            const subtotal = price * qty;
            row.querySelector('.subtotal').textContent = isNaN(subtotal) ? '-' : subtotal.toFixed(2);
            total += isNaN(subtotal) ? 0 : subtotal;
        });
        document.getElementById('total-amount').textContent = total.toFixed(2);
    }

    function updateRowData(select) {
        const row = select.closest('tr');
        const selected = select.options[select.selectedIndex];
        const price = selected.dataset.price || 0;
        const stock = selected.dataset.stock || 0;

        row.querySelector('.price').textContent = price;
        row.querySelector('.price').dataset.value = price;
        row.querySelector('.stock').textContent = stock;
        recalculateTotal();
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('add-row').addEventListener('click', () => {
            const newRow = document.querySelector('#order-items tr').cloneNode(true);
            newRow.querySelectorAll('select, input').forEach(el => {
                const name = el.getAttribute('name');
                if (name) {
                    el.setAttribute('name', name.replace(/\d+/, rowIdx));
                }
                el.value = '';
            });
            newRow.querySelector('.price').textContent = '-';
            newRow.querySelector('.stock').textContent = '-';
            newRow.querySelector('.subtotal').textContent = '-';
            newRow.querySelector('.price').dataset.value = 0;
            document.getElementById('order-items').appendChild(newRow);
            rowIdx++;
        });

        document.getElementById('order-items').addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                updateRowData(e.target);
            }
        });

        document.getElementById('order-items').addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity')) {
                recalculateTotal();
            }
        });

        document.getElementById('order-items').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                const rowCount = document.querySelectorAll('#order-items tr').length;
                if (rowCount > 1) {
                    e.target.closest('tr').remove();
                    recalculateTotal();
                }
            }
        });
    });
</script>
</body>
</html>
