import PropTypes from 'prop-types';
import { useTable } from 'react-table';
import styled from '@emotion/styled';

const StyledTable = styled.table``;
const StyledTableHead = styled.thead``;
const StyledTableBody = styled.tbody``;

function Table({ columns, data, ...props }) {
  const {
    getTableProps, getTableBodyProps, headerGroups, rows, prepareRow,
  } = useTable(
    {
      columns,
      data,
    },
  );

  return (
    <StyledTable className="wp-list-table widefat fixed striped table-view-list pages" {...getTableProps()} {...props}>
      <StyledTableHead>
        {headerGroups.map((headerGroup) => (
          <tr {...headerGroup.getHeaderGroupProps()}>
            {headerGroup?.headers?.map((column) => (
              <th {...column.getHeaderProps()}>
                {column.title}
              </th>
            ))}
          </tr>
        ))}
      </StyledTableHead>

      <StyledTableBody {...getTableBodyProps()}>
        {rows?.map((row) => {
          prepareRow(row);

          return (
            <tr {...row.getRowProps()}>
              {row.cells.map((cell) => <td {...cell.getCellProps()}>{cell.render('Cell')}</td>)}
            </tr>
          );
        })}
      </StyledTableBody>
    </StyledTable>
  );
}

Table.propTypes = {
  columns: PropTypes.array.isRequired,
  data: PropTypes.array.isRequired,
};

export default Table;
