import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  addToCart(event) {
    event.preventDefault();

    const productId = this.element.dataset.cartProductIdValue;
    const quantity = event.srcElement[0].value;

    fetch("/addToCart", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: `id=${productId}&nb=${quantity}`,
    });
  }

  deleteFromCart(event) {
    event.preventDefault();

    const productId = this.element.dataset.cartProductIdValue;

    fetch("/deleteFromCart", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: `id=${productId}`,
    }).then(() => {
      this.element.remove();
    });
  }

  modifyElementFromCart(event) {
    event.preventDefault();

    const productId = this.element.dataset.cartProductIdValue;
    const quantity = event.srcElement.value;

    fetch("/modifyElementFromCart", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: `id=${productId}&nb=${quantity}`,
    });
  }
}
