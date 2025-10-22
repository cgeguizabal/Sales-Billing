import { apiGet } from "./axiosInstance";

export async function getInvetoryKardex() {
  return apiGet("/inventoryTransactions");
}
