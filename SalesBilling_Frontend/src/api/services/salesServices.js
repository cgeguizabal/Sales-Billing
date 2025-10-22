// api/services/salesServices.js
import { apiGet } from "./axiosInstance";

export async function getAllSales() {
  return apiGet("/sales");
}

export async function getInvoice(saleId) {
  return apiGet(`/sales/${saleId}/invoice`, { responseType: "blob" });
}
