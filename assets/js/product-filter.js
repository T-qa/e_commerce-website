$(document).ready(() => {
  const rangeInputs = $(".range-input input");
  const priceInputs = $(".price-input input");
  const range = $(".slider .progress");
  let priceGap = 1000;
  priceInputs.each((index, priceInput) => {
    console.log(priceInput);
    $(priceInput).on("change", function (e) {
      console.log(this.value);
      // console.log(priceInputs[0].value);
    });
    $(priceInput).on("input", function (e) {
      console.log(e.target);
      let minPrice = parseInt(priceInputs[0].value),
        maxPrice = parseInt(priceInputs[1].value);

      if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInputs[1].max) {
        if (e.target.className === "input-min") {
          rangeInputs[0].value = minPrice;
          let leftStyle = (minPrice / rangeInputs[0].max) * 100 + "%";
          $(range).css({ left: `${leftStyle}` });
        } else {
          rangeInputs[1].value = maxPrice;
          let rightStyle = 100 - (maxPrice / rangeInputs[1].max) * 100 + "%";
          $(range).css({ right: `${rightStyle}` });
        }
      }
    });
  });
  rangeInputs.each((index, rangeInput) => {
    $(rangeInput).on("input", function (e) {
      let minVal = parseInt(rangeInputs[0].value),
        maxVal = parseInt(rangeInputs[1].value);
      if (maxVal - minVal < priceGap) {
        if (e.target.className === "range-min") {
          rangeInputs[0].value = maxVal - priceGap;
        } else {
          rangeInputs[1].value = minVal + priceGap;
        }
      } else {
        priceInputs[0].value = minVal;
        priceInputs[1].value = maxVal;
        let leftStyle = (minVal / rangeInputs[0].max) * 100 + "%";
        $(range).css({ left: `${leftStyle}` });
        let rightStyle = 100 - (maxVal / rangeInputs[1].max) * 100 + "%";
        $(range).css({ right: `${rightStyle}` });
      }
    });
  });
});
