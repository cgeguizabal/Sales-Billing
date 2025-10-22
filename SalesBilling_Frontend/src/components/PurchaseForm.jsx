import { useEffect, useState } from "react";
import { getAllSuppliers } from "../api/services/suppliersService";
import { getAllProducts } from "../api/services/productsService";
import { createPurchase } from "../api/services/purchaseService";
import styles from "../styles/components/purchaseForm.module.scss";

function PurchaseForm() {
  const [suppliers, setSuppliers] = useState([]);
  const [products, setProducts] = useState([]);
  const [selectedSupplier, setSelectedSupplier] = useState("");
  const [purchaseDetails, setPurchaseDetails] = useState([
    { product_id: "", quantity: "" },
  ]);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState("");

  useEffect(() => {
    fetchSuppliersAndProducts();
  }, []);

  const fetchSuppliersAndProducts = async () => {
    try {
      const supplierRes = await getAllSuppliers();
      const productRes = await getAllProducts();
      setSuppliers(
        Array.isArray(supplierRes.data) ? supplierRes.data : supplierRes
      );
      setProducts(
        Array.isArray(productRes.data) ? productRes.data : productRes
      );
    } catch (error) {
      console.error("Error loading data:", error);
    }
  };

  const handleDetailChange = (index, field, value) => {
    const updated = [...purchaseDetails];
    updated[index][field] = value;
    setPurchaseDetails(updated);
  };

  const addDetailRow = () => {
    setPurchaseDetails([...purchaseDetails, { product_id: "", quantity: "" }]);
  };

  const removeDetailRow = (index) => {
    const updated = purchaseDetails.filter((_, i) => i !== index);
    setPurchaseDetails(updated);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setMessage("");

    const validDetails = purchaseDetails.filter(
      (d) => d.product_id && d.quantity
    );

    const data = {
      supplier_id: Number(selectedSupplier),
      details: validDetails.map((d) => ({
        product_id: Number(d.product_id),
        quantity: Number(d.quantity),
      })),
    };

    try {
      const res = await createPurchase(data);
      setMessage("✅ Purchase created successfully!");
      console.log("Purchase created:", res);
      setPurchaseDetails([{ product_id: "", quantity: "" }]);
      setSelectedSupplier("");
    } catch (error) {
      console.error("Error creating purchase:", error);
      setMessage("❌ Failed to create purchase.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className={styles.container}>
      <h2>Create Purchase</h2>
      <form onSubmit={handleSubmit} className={styles.form}>
        <label>Supplier:</label>
        <select
          value={selectedSupplier}
          onChange={(e) => setSelectedSupplier(e.target.value)}
          required
        >
          <option value="">Select supplier</option>
          {suppliers.map((sup) => (
            <option key={sup.id} value={sup.id}>
              {sup.name}
            </option>
          ))}
        </select>

        <div className={styles.detailsSection}>
          <h3>Purchase Details</h3>
          {purchaseDetails.map((detail, index) => (
            <div key={index} className={styles.detailRow}>
              <select
                value={detail.product_id}
                onChange={(e) =>
                  handleDetailChange(index, "product_id", e.target.value)
                }
                required
              >
                <option value="">Select product</option>
                {products.map((prod) => (
                  <option key={prod.id} value={prod.id}>
                    {prod.name}
                  </option>
                ))}
              </select>

              <input
                type="number"
                min="1"
                value={detail.quantity}
                onChange={(e) =>
                  handleDetailChange(index, "quantity", e.target.value)
                }
                placeholder="Quantity"
                required
              />

              {purchaseDetails.length > 1 && (
                <button
                  type="button"
                  className={styles.removeBtn}
                  onClick={() => removeDetailRow(index)}
                >
                  ✖
                </button>
              )}
            </div>
          ))}

          <button
            type="button"
            onClick={addDetailRow}
            className={styles.addBtn}
          >
            + Add Product
          </button>
        </div>

        <button type="submit" disabled={loading} className={styles.submitBtn}>
          {loading ? "Saving..." : "Create Purchase"}
        </button>
      </form>
      {message && <p className={styles.message}>{message}</p>}
    </div>
  );
}

export default PurchaseForm;
