export const Class = state => {
  var getClass = state.test.class

  return getClass
}

export const Subjects = state => {
  var getSubjects = state.test.subjects

  return getSubjects
}

export const Partitions = state => {
  var getPartitions = state.test.partitions

  return getPartitions
}

export const Questions = state => {
  var getQuestions = state.test.questions

  return getQuestions
}

export const User = state => {
  var user = state.user

  return user
}
