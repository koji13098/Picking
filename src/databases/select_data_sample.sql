SELECT
  l.location,
  o.item_number,
  o.amount
FROM
  orders as o
    INNER JOIN locations as l
      ON o.item_number = l.item_number
WHERE
  invoice = 1234567890
;
