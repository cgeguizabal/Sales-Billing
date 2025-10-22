import { apiDelete, apiGet, apiPut } from "./axiosInstance";

export const getUsers = () => {
  return apiGet("/users");
};
