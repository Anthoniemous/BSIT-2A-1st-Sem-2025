import React, { useEffect, useState } from "react";
import { useMenu } from "../ContextProvider/ContextProvider";
import { Link } from "react-router";
const HiddenMenu = () => {
  const { show, setShow } = useMenu();
  const hideMenu = () => {
    setShow(false);
  };
  useEffect(() => {
    console.log(show);
  }, [show]);

  return (
    <>
      {show ? (
        <div className="bg-black text-white w-70 gap-10 grid grid-cols-2 top-[0px] text-center font-mono rounded-xl p-5 fixed  list-none transition delay-200 duration-300">
          <Link to="/">
            <li
              className="hover:underline underline-offset-8"
              onClick={hideMenu}
            >
              Products
            </li>
          </Link>
          <Link to="/menclothing">
            <li
              className="hover:underline underline-offset-8"
              onClick={hideMenu}
            >
              Clothing
            </li>
          </Link>

          <Link to="/electronics">
            <li
              className="hover:underline underline-offset-8"
              onClick={hideMenu}
            >
              Electronics
            </li>
          </Link>
          <Link to="/jewelry">
            <li
              className="hover:underline underline-offset-8"
              onClick={hideMenu}
            >
              Jewelry
            </li>
          </Link>
        </div>
      ) : (
        <div className="bg-black text-white w-70 gap-10 flex flex-col top-[-450px] text-center font-mono rounded-xl p-5 fixed  list-none">
          <Link to="/">
            <li className="hover:underline underline-offset-8">Products</li>
          </Link>
          <Link to="/menclothing">
            <li className="hover:underline underline-offset-8">Clothing</li>
          </Link>

          <Link to="/electronics">
            <li className="hover:underline underline-offset-8">Electronics</li>
          </Link>
          <Link to="/jewelry">
            <li className="hover:underline underline-offset-8">Jewelry</li>
          </Link>
        </div>
      )}
    </>
  );
};

export default HiddenMenu;
