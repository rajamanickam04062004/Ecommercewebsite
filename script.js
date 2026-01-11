const menuBtn = document.getElementById('menuBtn');
const menuList = document.getElementById('menulist');
const productList = document.getElementById('productList');
const product1 = document.getElementById('product1');
const customerDetails = document.getElementById('customerDetails');

// Menu open/close
menuBtn.addEventListener('click', (e) => {
  e.stopPropagation();
  menuList.classList.toggle('show');
});

document.addEventListener('click', (e) => {
  if (menuList.classList.contains('show')) {
    menuList.classList.remove('show');
  }
});

menuList.addEventListener('click', (e) => {
  e.stopPropagation();
});

// Show Customer Details on Product 1 Click
product1.addEventListener('click', () => {
  customerDetails.classList.add('show');
});

document.addEventListener('click', (e) => {
  if (e.target !== product1 && !customerDetails.contains(e.target)) {
    customerDetails.classList.remove('show');
  }
});

// Auto Scroll on Hover
let scrollInterval;

productList.addEventListener('mouseenter', () => {
  scrollInterval = setInterval(() => {
    productList.scrollLeft += 2;
    if (productList.scrollLeft >= productList.scrollWidth - productList.clientWidth) {
      productList.scrollLeft = 0;
    }
  }, 20);
});

productList.addEventListener('mouseleave', () => {
  clearInterval(scrollInterval);
});

//search bar code 600px//

  
