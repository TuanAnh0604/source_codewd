document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.dataset.productId;

        if (confirm('Are you sure you want to delete this product?')) {
            fetch('delete_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.reload(); // Tải lại trang sau khi xóa
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
                console.error(error);
            });
        }
    });
});
