import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  disabledSubmit(value) {
    document.getElementById("wallet_submit").disabled = value;
  }

  validateAllFields() {
    let shouldDisable = false;

    if (this.index === 0) {
      shouldDisable = false;
    } else {
      for (let i = 0; i < this.index; i++) {
        const numberField = document.getElementById(
          "wallet_creditCards_" + i + "_number"
        );
        const cvvField = document.getElementById(
          "wallet_creditCards_" + i + "_cvv"
        );

        if (!numberField || !cvvField) {
          continue;
        }

        const isNumberInvalid = numberField.value.length < 16;
        const isCvvInvalid = cvvField.value.length < 3;

        numberField.classList.toggle("is-invalid", isNumberInvalid);
        cvvField.classList.toggle("is-invalid", isCvvInvalid);

        if (isNumberInvalid || isCvvInvalid) {
          shouldDisable = true;
        }
      }
    }

    this.disabledSubmit(shouldDisable);
  }

  addOnlyNumberListener(i) {
    const numberField = document.getElementById(
      "wallet_creditCards_" + i + "_number"
    );
    const cvvField = document.getElementById(
      "wallet_creditCards_" + i + "_cvv"
    );

    numberField.addEventListener("input", (event) => {
      event.target.value = event.target.value.replace(/\D/g, "");
      this.validateAllFields();
    });

    cvvField.addEventListener("input", (event) => {
      event.target.value = event.target.value.replace(/\D/g, "");
      this.validateAllFields();
    });
  }

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

    for (let i = 0; i < this.index; i++) {
      this.addOnlyNumberListener(i);
    }

    this.element.append(btn);
    this.validateAllFields();
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
    this.addOnlyNumberListener(this.index - 1);
    this.validateAllFields();
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
      this.index--;
      this.validateAllFields();
    });
  };
}
