import React, { useEffect, useState } from "react";
import axios from "axios";
import AllProductsCard from "./AllProductsCard";
import { Link } from "react-router";
import { useSearchHistory } from "../ContextProvider/ContextProvider";

function AllProduct() {
  const [products, setProducts] = useState();
  const [copy, setCopy] = useState();
  const { value, setValue } = useSearchHistory();
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
        setCopy(response.data);
        setProducts(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, []);

  useEffect(() => {
    if (value) {
      const filtered = products.filter(handleSearch);
      setProducts(filtered);
    } else {
      setProducts(copy);
    }
  }, [value]);

  const handleSearch = (product) => {
    return product.title.includes(value);
  };

  const shortenString = (name) => {
    return name.split("").splice(0, 8).join("") + "...";
  };

  return (
    <>
      <div className="grid grid-cols-1   justify-items-center mt-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4  gap-5 ">
        {products &&
          products.map((product) => (
            <Link to={`/product/${product.id}`}>
              <AllProductsCard
                key={product.id}
                price={product.price}
                image={product.image}
                title={shortenString(product.title)}
              />
            </Link>
          ))}
      </div>
    </>
  );
}

export default AllProduct;
