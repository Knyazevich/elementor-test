import PropTypes from 'prop-types';

const alertClasses = {
  positive: 'updated notice-success',
  negative: 'error notice-error',
};

function Alert({ variant, children }) {
  return (
    <div id="message" className={variant ? alertClasses[variant] : alertClasses.info}>
      <p>{children}</p>
    </div>
  );
}

Alert.propTypes = {
  variant: PropTypes.oneOf(['positive', 'negative']),
  children: PropTypes.string,
};

Alert.defaultProps = {
  variant: 'positive',
  children: '',
};

export default Alert;
