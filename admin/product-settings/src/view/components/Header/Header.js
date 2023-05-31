import PropTypes from 'prop-types';
import styled from '@emotion/styled';
import GlobalAlert from '../GlobalAlert/GlobalAlert';

const StyledHeaderWrapper = styled.header`
  display: flex;
  justify-content: flex-start;
  align-items: center;
  padding-bottom: 30px;
`;

const StyledHeaderHeading = styled.h1`
  font-size: 23px;
  font-weight: 400;
  line-height: 1.3;
`;

function Header({ title, children }) {
  return (
    <>
      <StyledHeaderWrapper>
        <StyledHeaderHeading>
          {title}
        </StyledHeaderHeading>

        {children}
      </StyledHeaderWrapper>

      <GlobalAlert />
    </>
  );
}

Header.propTypes = {
  title: PropTypes.string.isRequired,
  children: PropTypes.node,
};

Header.defaultProps = {
  children: null,
};

export default Header;
