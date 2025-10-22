import { apiPost } from "./axiosInstance";

export async function createPurchase(data) {
  return apiPost("/purchases", data);
}
