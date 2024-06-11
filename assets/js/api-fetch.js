const selectCity = document.querySelector("#city");
const selectDistrict = document.querySelector("#district");
const selectWard = document.querySelector("#ward");
document.addEventListener("DOMContentLoaded", async () => {
  fetch("https://provinces.open-api.vn/api/?depth=2")
    .then((res) => {
      return res.json();
    })
    .then((data) => {
      let output = `<option selected>Choose City</option>`;
      data.forEach((city) => {
        output += `<option value='${city.name}'>${city.name}</option>`;
      });
      selectCity.innerHTML = output;
    })
    .catch((err) => {
      console.log(err);
    });
});

let cityCode = "";
async function fetchCityCode() {
  let selectValue = document.getElementById("city").value;
  const response = await fetch(
    `https://provinces.open-api.vn/api/p/search/?q=${selectValue}`
  );
  return response.json();
}

async function fetchDistrict() {
  const response = await fetch(
    `https://provinces.open-api.vn/api/p/${cityCode}?depth=2`
  );
  return response.json();
}

selectCity.addEventListener("change", async () => {
  fetchCityCode()
    .then((data) => {
      cityCode = data[0].code;
    })
    .catch((err) => {
      console.log(err);
    });
});

async function fetchDistrict() {
  let promise = new Promise((resolve, reject) => {
    setTimeout(() => resolve("done!"), 350);
  });

  let result = await promise;

  const response = await fetch(
    `https://provinces.open-api.vn/api/p/${cityCode}?depth=2`
  );
  return response.json();
}

selectCity.addEventListener("change", () => {
  fetchDistrict()
    .then((data) => {
      let output = `<option selected>Choose District</option>`;
      for (let i = 0; i < data.districts.length; i++) {
        output += `<option value='${data.districts[i].name}'>${data.districts[i].name}</option>`;
      }
      selectDistrict.innerHTML = output;
    })
    .catch((err) => {
      console.log(err);
    });
});

async function fetchDistrictCode() {
  let selectValue = document.getElementById("district").value;
  const response = await fetch(
    `https://provinces.open-api.vn/api/d/search/?q=${selectValue}`
  );
  return response.json();
}

let districtCode = "";
selectDistrict.addEventListener("change", () => {
  fetchDistrictCode()
    .then((data) => {
      districtCode = data[0].code;
      console.log(districtCode);
    })
    .catch((err) => {
      console.log(err);
    });
});

async function fetchWard() {
  let promise = new Promise((resolve, reject) => {
    setTimeout(() => resolve("done!"), 350);
  });

  let result = await promise;
  const response = await fetch(
    `https://provinces.open-api.vn/api/d/${districtCode}?depth=2`
  );
  return response.json();
}

selectDistrict.addEventListener("change", () => {
  fetchWard()
    .then((data) => {
      console.log(data.wards);
      let output = `<option selected>Choose Ward</option>`;
      for (let i = 0; i < data.wards.length; i++) {
        output += `<option value='${data.wards[i].name}'>${data.wards[i].name}</option>`;
      }
      selectWard.innerHTML = output;
    })
    .catch((err) => {
      console.log(err);
    });
});
