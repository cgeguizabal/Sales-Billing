import { apiGet, apiPost } from "./axiosInstance";

export async function registerProduct(data) {
  return apiPost("/products", data);
}

export async function getAllProducts() {
  return apiGet("/products");
}
