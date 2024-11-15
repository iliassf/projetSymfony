form = document.getElementById("addToCartForm");

form.addEventListener("submit", function (event) {
  event.preventDefault();

  const productId = form.getAttribute("data-product-id");
  const quantity = form.querySelector("input[name='quantity']").value;

  fetch("/addToCart", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
      "X-Requested-With": "XMLHttpRequest",
    },
    body: `id=${productId}&nb=${quantity}`,
  });
});
