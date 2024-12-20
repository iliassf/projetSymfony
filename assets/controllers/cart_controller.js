import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  changeHeaderCartSize(cartSize) {
    document.getElementsByClassName("cartSize")[0].textContent = cartSize;
  }

  changeSousTotal(sousTotal) {
    document.getElementsByClassName("sousTotal")[0].textContent =
      "Sous total : " + Math.trunc(sousTotal * 100) / 100 + " €";
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
    const quantity = parseInt(event.srcElement.value, 10);

    if (quantity <= 0) {
      this.deleteFromCart(event);
      return;
    }

    fetch("/modifyElementFromCart", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: `id=${productId}&nb=${quantity}`,
    })
      .then((Response) => Response.json())
      .then((json) => {
        document.getElementsByClassName("sous-" + productId)[0].textContent =
          Math.trunc(json.sousProduct * 100) / 100 + " €";
        this.changeSousTotal(json.sousTotal);
        this.changeHeaderCartSize(json.cartSize);
      });
  }

  sendForm(event) {
    event.preventDefault();

    fetch("/sendOrder", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: ``,
    }).then((Response) => {
      if (Response.ok) {
        document.getElementsByClassName("divRecap")[0].style.display = "none";
        let divCart = document.getElementsByClassName("divCart")[0];
        while (divCart.firstChild) {
          divCart.removeChild(divCart.firstChild);
        }
        let title = document.createElement("h4");
        title.textContent =
          "La ParfumerieOnline vous remercie pour votre commande.";
        document.getElementsByClassName("divCart")[0].appendChild(title);
        let paragraph = document.createElement("p");
        paragraph.textContent =
          "Nos équipes s'en occupent afin que vous la receviez dans les plus brefs délais.";
        document.getElementsByClassName("divCart")[0].appendChild(paragraph);

        this.changeHeaderCartSize(0);
      } else {
        document.getElementsByClassName("errorMessage")[0].textContent =
          "L'achat n'a pas pu aboutir...";
      }
    });
  }
}
