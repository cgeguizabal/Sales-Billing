import { useEffect, useState } from "react";
import { getInvetoryKardex } from "../api/services/inventoryTransactionsService";
import styles from "../styles/components/kardexReport.module.scss";

function KardexReport() {
  const [kardex, setKardex] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    fetchKardex();
  }, []);

  const fetchKardex = async () => {
    setLoading(true);
    try {
      const res = await getInvetoryKardex();
      const data = res.data || res;
      setKardex(Array.isArray(data) ? data : data.data || []);
    } catch (error) {
      console.error("Error fetching Kardex:", error);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className={styles.container}>
      <h2>Kardex Report</h2>

      {loading ? (
        <p>Loading inventory data...</p>
      ) : (
        <div className={styles.table}>
          <div className={styles.headerRow}>
            <span>Product</span>
            <span>Type</span>
            <span>Date</span>
            <span>Quantity</span>
          </div>

          {kardex.map((item) => (
            <div key={item.id} className={styles.row}>
              <span className={styles.product}>{item.product_name}</span>
              <span
                className={`${styles.type} ${
                  item.transaction_type === "purchase"
                    ? styles.purchase
                    : styles.sale
                }`}
              >
                {item.transaction_type}
              </span>
              <span className={styles.date}>
                {new Date(item.transaction_date).toLocaleString()}
              </span>
              <span className={styles.quantity}>{item.quantity}</span>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

export default KardexReport;
