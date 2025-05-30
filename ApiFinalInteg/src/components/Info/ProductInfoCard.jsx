import React, { useEffect } from "react";

function ProductInfoCard({ img, name, price, description, rating, stocks }) {
  return (
    <div className="flex justify-around  mb-10 mr-auto ml-auto  mt-8 border border-gray-300  rounded-xl p-7 max-sm:flex-col sm:flex-col w-[97%] md:flex-row  h-mvh shadow-black">
      <div className=" flex flex-col gap-5 w-auto md:flex md:flex-row justify-center  md:gap-20 items-center lg:gap-40 p-3 ">
        <img src={img} className="h-50 max-sm:40 md:h-90 mt-20 max-w-100"></img>
        <div className="w-auto  flex flex-col items-center gap-7 mt-10 lg:text-xl">
          <h1 className="text-lg font-bold text-center md:text-xl sm:max-sm:text-sm w-auto lg:text-2xl">
            {name}
          </h1>
          <section className="flex flex-col gap-1 text-center   ">
            <h2 className=" font-bold w-auto">Product Description:</h2>
            <p className="text-sm w-auto lg:text-lg xl:w-150 md:text-base ">
              {description}
            </p>
          </section>
          <section className="flex gap-8 sm:max-sm:flex-col items-center">
            <p className="font-medium ">Available: {stocks}</p>

            <p className="font-medium">${price}</p>
          </section>
          <section className="flex gap-5 items-center font-bold max-sm:flex-col w-full justify-center">
            <button className="bg-black text-white w-[50%] p-4 rounded-lg text-md">
              Buy
            </button>
            <button className="border border-gray-400 w-[50%] p-4  rounded-lg">
              Add to Cart
            </button>
          </section>
        </div>
      </div>
    </div>
  );
}

export default ProductInfoCard;
