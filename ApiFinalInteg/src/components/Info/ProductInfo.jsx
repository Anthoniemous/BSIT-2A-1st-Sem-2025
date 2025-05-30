import React, { useEffect, useState } from "react";
import { useParams } from "react-router";
import axios from "axios";
import ProductInfoCard from "./ProductInfoCard";
function ProductInfo() {
  //id from dynamic routing :id
  const { id } = useParams();
  const [products, setProducts] = useState();

  useEffect(() => {
    let config = {
      method: "get",
      maxBodyLength: Infinity,
      url: `https://fakestoreapi.com/products/${id}`,
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
        console.error(error);
      });
  }, [id]);

  return (
    <div>
      {products && (
        <ProductInfoCard
          key={products.id}
          name={products.title}
          img={products.image}
          price={products.price}
          description={products.description}
          rating={products.rating.rate}
          stocks={products.rating.count}
        />
      )}
    </div>
  );
}

export default ProductInfo;
