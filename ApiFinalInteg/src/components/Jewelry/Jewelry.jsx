import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";
import { Link } from "react-router";
import JewelryCard from "./JewelryCard";
import { useSearchHistory } from "../ContextProvider/ContextProvider";
function Jewelry() {
  const [products, setProducts] = useState();
  const [jewelry, setJewelry] = useState();
  const [copy, setCopy] = useState();
  const { value } = useSearchHistory();

  useEffect(() => {
    let config = {
      method: "get",
      maxBodyLength: Infinity,
      url: "https://fakestoreapi.com/products",
      headers: {
        "x-rapidapi-key": "b87e99e919msh6176ee1540351d0p17b2b8jsn6ad19e3992f3",
        "x-rapidapi-host":
          "ai-text-to-image-generator-flux-free-api.p.rapidapi.com",
        "Content-Type": "application/json",
      },
    };

    axios
      .request(config)
      .then((response) => {
        setProducts(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, []);

  const filterJewelry = (item) => {
    return item.category.includes("jewelery");
  };
  const shortenString = (name) => {
    return name.split("").splice(0, 8).join("") + "...";
  };
  const handleSearch = (item) => {
    return item.title.includes(value);
  };

  useEffect(() => {
    if (products) {
      console.log("Changed");
      const getJewelry = products.filter(filterJewelry);
      setJewelry(getJewelry);
      setCopy(getJewelry);
    }
  }, [products]);

  useEffect(() => {
    if (value) {
      const filtered = jewelry.filter(handleSearch);
      setJewelry(filtered);
    } else {
      setJewelry(copy);
    }
  }, [value]);
  return (
    <>
      <div className="grid grid-cols-1  justify-items-center mt-5 sm:grid-cols-2 md:grid-cols-3 gap-5 ">
        {jewelry &&
          jewelry.map((product) => (
            <Link to={`/product/${product.id}`}>
              <JewelryCard
                key={product.id}
                title={shortenString(product.title)}
                price={product.price}
                image={product.image}
              />
            </Link>
          ))}
      </div>
    </>
  );
}

export default Jewelry;
