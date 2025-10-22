import { apiGet, apiPost } from "./axiosInstance";

export async function registerCategory(data) {
  return apiPost("/categories", data);
}

export async function getAllCategories() {
  return apiGet("/categories");
}
