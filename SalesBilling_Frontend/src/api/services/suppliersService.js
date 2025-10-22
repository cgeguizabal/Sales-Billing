import { apiGet } from "./axiosInstance";

export async function getAllSuppliers() {
  return apiGet("/suppliers");
}
