import { apiPost } from "./axiosInstance";

export async function registerProduct(data) {
  return apiPost("/products", data);
}
