// import axios from "axios";
import { apiPost } from "./axiosInstance";

export async function registerUser(data) {
  return apiPost("/register", data);
}

export async function login(data) {
  return apiPost("/login", data);
}

export async function logout() {
  return apiPost("/logout");
}
