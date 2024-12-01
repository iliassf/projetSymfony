import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    this.index = this.element.childElementCount;

    const btn = document.createElement("button");
    btn.setAttribute("class", "btn btn-secondary");
    btn.innerText = "Ajouter une carte";
    btn.setAttribute("type", "button");
    btn.addEventListener("click", (e) => this.addElement(e));

    this.element.childNodes.forEach((node) => {
      if (node.nodeType === Node.ELEMENT_NODE) {
        this.addDeleteButton(node);
      }
    });

    this.element.append(btn);
  }

  addElement = (e) => {
    e.preventDefault();
    const element = document
      .createRange()
      .createContextualFragment(
        document
          .getElementById("wallet_creditCards")
          .dataset["prototype"].replaceAll("__name__", this.index)
      ).firstElementChild;

    this.addDeleteButton(element);
    this.index++;
    e.currentTarget.insertAdjacentElement("beforebegin", element);
  };

  addDeleteButton = (item) => {
    const btn = document.createElement("button");
    btn.setAttribute("class", "btn btn-danger");
    btn.innerText = "Supprimer";
    btn.setAttribute("type", "button");
    item.append(btn);

    btn.addEventListener("click", (e) => {
      e.preventDefault();
      item.remove();
    });
  };
}
