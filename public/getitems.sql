SELECT i.id, i.name, CONCAT('[', GROUP_CONCAT('{"id":', k.id ,CONCAT(',"name":"', k.name, '","rate":"', k.rate,'"}')),']') AS taxes from items i INNER JOIN item_taxes j ON i.id = j.item_id INNER JOIN taxes k ON j.tax_id = k.id GROUP BY i.id, i.name