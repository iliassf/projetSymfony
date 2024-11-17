import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  changeHeaderCartSize(cartSize) {
    document.getElementsByClassName("cartSize")[0].textContent = cartSize;
  }

  changeSousTotal(sousTotal) {
    document.getElementsByClassName("sousTotal")[0].textContent =
      sousTotal + " €";
  }

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
    })
      .then((Response) => {
        return Response.json();
      })
      .then((json) => {
        this.changeHeaderCartSize(json.cartSize);
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
    })
      .then((Response) => {
        return Response.json();
      })
      .then((json) => {
        this.element.remove();
        this.changeHeaderCartSize(json.cartSize);
        if (json.cart.length == 0) {
          let title = document.createElement("h4");
          title.textContent = "Votre panier est vide...";
          document.getElementsByClassName("divCart")[0].appendChild(title);
          document.getElementsByClassName("divRecap")[0].style.display = "none";
        } else {
          this.changeSousTotal(json.sousTotal);
        }
      });
  }

  modifyElementFromCart(event) {
    event.preventDefault();

    const productId = this.element.dataset.cartProductIdValue;
    const quantity = event.srcElement.value;

    //console.log(document.getElementsByClassName("sousTotal"));
    //document.getElementsByClassName("sous-" + productId)[0].textContent = ("bonjour");

    fetch("/modifyElementFromCart", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: `id=${productId}&nb=${quantity}`,
    })
      .then((Response) => {
        return Response.json();
      })
      .then((json) => {
        document.getElementsByClassName("sous-" + productId)[0].textContent =
          json.sousProduct + " €";
        this.changeSousTotal(json.sousTotal);
        this.changeHeaderCartSize(json.cartSize);
      });
  }
}
