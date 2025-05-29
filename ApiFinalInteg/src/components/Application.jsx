import React from "react";
import AllProduct from "./Allproducts/AllProduct";
import { BrowserRouter, Route, Routes } from "react-router";
import Appliances from "./Electronics/Appliances";
import MenClothing from "./Clothing/Clothing";
import Jewelry from "./Jewelry/Jewelry";
import ProductInfo from "./Info/ProductInfo";
import Navbar from "./Navbar";
import ContextProvider from "./ContextProvider/ContextProvider";

function Application() {
  return (
    <ContextProvider>
      <BrowserRouter>
        <Navbar />
        <Routes>
          <Route path="/">
            <Route index element={<AllProduct />} />
            <Route path="product/:id" element={<ProductInfo />} />
            <Route path="/electronics" element={<Appliances />}>
              <Route path="product/:id" element={<ProductInfo />} />
            </Route>
            <Route path="/menclothing" element={<MenClothing />}>
              <Route path="product/:id" element={<ProductInfo />} />
            </Route>
            <Route path="/jewelry" element={<Jewelry />}>
              <Route path="product/:id" element={<ProductInfo />} />
            </Route>
          </Route>
        </Routes>
      </BrowserRouter>
    </ContextProvider>
  );
}

export default Application;
