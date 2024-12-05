// Lấy container sản phẩm và nút "Xem tất cả"
const productContainer = document.getElementById('productContainer');
const viewMoreBtn = document.getElementById('viewMoreBtn');

// Danh sách các sản phẩm bổ sung
const moreProducts = [
    {
        name: 'Giày chạy thể thao nam Pro-stable',
        price: '799,000đ',
        image: 'https://via.placeholder.com/150'
    },
    {
        name: 'Giày thể thao nam Classic',
        price: '699,000đ',
        image: 'https://via.placeholder.com/150'
    },
    {
        name: 'Giày tập thể thao nam Basic Running',
        price: '599,000đ',
        image: 'https://via.placeholder.com/150'
    },
    {
        name: 'Giày chạy bộ nam Ultra-light',
        price: '899,000đ',
        image: 'https://via.placeholder.com/150'
    }
];

// Xử lý sự kiện khi nhấn nút "Xem tất cả"
viewMoreBtn.addEventListener('click', function () {
    // Tạo và thêm các sản phẩm mới vào container
    moreProducts.forEach(product => {
        const productDiv = document.createElement('div'); // Tạo div mới cho sản phẩm
        productDiv.classList.add('product'); // Thêm class "product"
        productDiv.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <p class="product-name">${product.name}</p>
            <p class="product-price">${product.price}</p>
        `;
        productContainer.appendChild(productDiv); // Thêm sản phẩm vào container
    });

    // Ẩn nút "Xem tất cả" sau khi hiển thị thêm sản phẩm
    this.style.display = 'none';
});
